<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $active
 * @property string $birthday
 * @property string $phone
 * @property string $address
 * @property integer $commentPermission
 *
 * @property Users $user
 */
class Profile extends \yii\db\ActiveRecord
{

     public $newPassword;
     public $editPassword = true;
     public $newRole;
     public $picture;
     public $dob;
     public $username;


     public function __construct(){


          if(!file_exists(Yii::getAlias('@profilePictures'))){     // create images/profile directory to store profile pictures
               FileHelper::createDirectory(Yii::getAlias('@profilePictures'), '0777');
          }

          /*
          if(!file_exists('images/profile/')){     // create images/profile directory to store profile pictures
               FileHelper::createDirectory('images/profile/', '0777');
          }
          */
          $this->newRole = key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));

     }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['userId'], 'integer'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            ['username', 'required', 'on' => 'editProfile'],
            ['editPassword', 'boolean', 'on' => 'editProfile'],
            [['active', 'commentPermission'], 'boolean', 'on' => 'editProfile'],
            ['newPassword', 'string', 'on' => 'editProfile'],
            ['editPassword', 'validateEditPassword', 'on' => 'editProfile'],
            [['picture'], 'file', 'extensions' => 'png, jpg', 'on' => 'editPicture'],
            [['dob'], 'required', 'on' => 'profileInfo'],
            ['dob', 'validateDob', 'on' => 'profileInfo'],
            [['dob','phone','address'], 'string', 'max' => 255],
            [['phone'], PhoneInputValidator::className()],
            ['phone', 'validatePhone', 'on' => 'profileInfo'],
            ['address', 'validateAddress', 'on' => 'profileInfo'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'New username',
            'id' => 'ID',
            'userId' => 'User ID',
            'active' => 'Press to change your profile status (allow or do not allow to users find you by using search)',
            'birthday' => 'Birthday',
            'phone' => '',
            'address' => 'Address',
            'dob' => 'Date of Birth',
            'commentPermission' => 'Press to change your comment permission (allow or do not allow to users add comments to your posts)',
        ];
    }

    public function behaviors()
    {
       return [
            'phoneInput' => [
                 'class' => PhoneInputBehavior::className(),
                 'attributes' => ['phone'],
            ],
       ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function beforeSave($insert){

        if(!empty($this->user)){
             $this->user->username = $this->username;
             $this->user->newRole = $this->user->userRole;
        }

        return parent::beforeSave($insert);

    }

    public function validateDob(){

         $currentDate = Yii::$app->getFormatter()->asDateTime(time());
         if((strtotime($currentDate) < strtotime($this->dob)) || (strtotime($this->dob) === -1)){
              $this->addError('dob', 'Incorrect date, please choose correct date!');
         }
         else{
             //echo 'Max int: '.PHP_INT_MAX.' Calculated: '.(strtotime($currentDate) - strtotime($this->dob)).' Calc: '.(PHP_INT_MAX-(strtotime($currentDate) - strtotime($this->dob)));
             //$years = (int)((strtotime($currentDate) - strtotime($this->dob))/31104000);
             $years = getdate(strtotime($currentDate))['year'] - substr($this->dob, 7);
             if(($years < 5) || ($years > 90)){
                 $this->addError('dob', 'Your age can\'t be less then 5 and greater then 90 years!');
             }
             else{
                  $this->birthday = $this->dob;
             }
         }

    }

    public function validatePhone(){

         $phone = Profile::find()->where(['phone' => $this->phone])->one();
         if(!empty($phone) && (Yii::$app->user->id != $phone->id)){
              $this->addError('phone', 'This phone number already exists!');
         }

    }

    public function validateAddress(){

         $this->address = trim($this->address);
         if(strlen($this->address) == 0){
              $this->addError('address', 'You can\'t leave address empty!');
         }

    }

    public function validateEditPassword(){
         $this->newPassword = trim($this->newPassword);
         if($this->editPassword){
              if(isset($this->newPassword) && (strlen($this->newPassword) != 0)){
                   $this->user->password = $this->newPassword;    // and then beforeSave add hash
              }
              else{
                   $this->addError('newPassword', 'You can\'t leave new password empty!');
              }
         }
    }

}
