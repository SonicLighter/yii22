<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property integer $senderId
 * @property integer $receiverId
 * @property integer $accepted
 *
 * @property Users $receiver
 * @property Users $sender
 */
class Friends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receiverId', 'accepted'], 'required'],
            [['receiverId', 'accepted'], 'integer'],
            [['receiverId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['receiverId' => 'id']],
            [['senderId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['senderId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'senderId' => 'Sender ID',
            'receiverId' => 'Receiver ID',
            'accepted' => 'Accepted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(Users::className(), ['id' => 'receiverId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Users::className(), ['id' => 'senderId']);
    }

    public static function findFriends($userId){

         return Friends::find()->where(['or', 'senderId' => $userId, 'receiverId' => $userId])->all();

    }

    public static function addPermission($userId){

         $userExists = User::findIdentity($userId);    // user which you are going to add
         /*$findFriend = Friends::find()->where(['or', 'senderId' => Yii::$app->user->identity->id, 'receiverId' => Yii::$app->user->identity->id])
                                      ->andWhere(['or', 'senderId' => $userId, 'receiverId' => $userId])->one();*/
         $findFriend = Friends::find()->where(['or', ['and', 'senderId' => Yii::$app->user->id, 'receiverId' => $userId], ['and', 'senderId' => $userId, 'receiverId' => Yii::$app->user->id]])->one();
         echo " senderId: ".$findFriend->senderId." receiverId: ".$findFriend->receiverId."<br/>";
         if(empty($userExists) || !empty($findFriend)){ // !empty($findFriend) means that friendship already exists
              echo "NO!";
         }
         else{
              echo "YES!";
         }
         die();

    }
}
