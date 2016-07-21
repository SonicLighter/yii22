<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class Role extends \yii\db\ActiveRecord
{

     public $allowComments = true;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['item_name', 'validateRole', 'on' => 'create'],
            [['item_name'], 'required', 'on' => 'create'],
            ['allowComments', 'boolean'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            //[['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    public function validateRole(){

         $auth = YII::$app->authManager;
         $newRole = $auth->getRole($this->item_name);
         if(!empty($newRole)){
              $this->addError('item_name', 'Such role already exists!');
         }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getRoles(){

         $result = array();
         $array = Role::find()->select('item_name')->distinct()->all();
         foreach ($array as $a) {
              $result[$a->item_name] = $a->item_name;
         }

         return $result;

    }

    public static function getDataProvider(){

         $query = Role::find()->select('item_name')->distinct();

         $dataProvider = new ActiveDataProvider([
              'query' => $query,
         ]);

         return $dataProvider;

    }

}
