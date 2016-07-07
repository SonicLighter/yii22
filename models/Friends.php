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
         $findFriend = Friends::find()->where('(senderId = '.Yii::$app->user->id.' AND receiverId = '.$userId.') OR
                                   (senderId = '.$userId.' AND receiverId = '.Yii::$app->user->id.')')->one();
         if(empty($userExists) || !empty($findFriend) || (Yii::$app->user->id == $userId)){ // !empty($findFriend) means that friendship already exists
              return false;
         }

         return true;

    }
}
