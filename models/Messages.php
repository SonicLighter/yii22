<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $receiverId
 * @property string $message
 * @property integer $opened
 *
 * @property Users $receiver
 * @property Users $sender
 */

class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['senderId', 'receiverId', 'message', 'opened'], 'required'],
            [['senderId', 'receiverId', 'opened'], 'integer'],
            [['message'], 'string'],
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
            'id' => 'ID',
            'senderId' => 'Sender ID',
            'receiverId' => 'Receiver ID',
            'message' => 'Message',
            'opened' => 'Opened',
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

    public static function getUserDialogs(){

         $arraySender = ArrayHelper::getColumn(Messages::find()->where(['senderId' => Yii::$app->user->id])->groupBy('receiverId')->all(), 'receiverId');
         $arrayReceiver = ArrayHelper::getColumn(Messages::find()->where(['receiverId' => Yii::$app->user->id])->groupBy('senderId')->all(), 'senderId');
         return ArrayHelper::merge($arraySender, $arrayReceiver);

    }

}

?>
