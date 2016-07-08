<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            [['receiverId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiverId' => 'id']],
            [['senderId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['senderId' => 'id']],
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
        return $this->hasOne(User::className(), ['id' => 'receiverId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'senderId']);
    }

    public static function findFriend($userId){
         return Friends::find()->where('(senderId = '.Yii::$app->user->id.' AND receiverId = '.$userId.') OR
                                   (senderId = '.$userId.' AND receiverId = '.Yii::$app->user->id.')')->one();
    }

    public static function getUserFriends(){

         $arraySender = ArrayHelper::getColumn(Friends::find()->where(['senderId' => Yii::$app->user->id, 'accepted' => 1])->all(), 'receiverId');
         $arrayReceiver = ArrayHelper::getColumn(Friends::find()->where(['receiverId' => Yii::$app->user->id, 'accepted' => 1])->all(), 'senderId');
         return ArrayHelper::merge($arraySender, $arrayReceiver);

    }
}
