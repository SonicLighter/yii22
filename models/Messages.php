<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

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
            [['senderId', 'receiverId', 'message', 'opened', 'date'], 'required'],
            [['senderId', 'receiverId', 'opened'], 'integer'],
            [['message', 'date'], 'string'],
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

    public static function getUserMessages($userId){

         $query = Messages::find()->where(['senderId' => Yii::$app->user->id, 'receiverId' => $userId])->orWhere(['senderId' => $userId, 'receiverId' => Yii::$app->user->id])->orderBy('id DESC');

         $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' =>[
                   'pageSize' => 10,
              ],
         ]);

         return $dataProvider;

    }

    public static function getMessagePages($userId){

         return Messages::find()->where(['senderId' => Yii::$app->user->id, 'receiverId' => $userId])->orWhere(['senderId' => $userId, 'receiverId' => Yii::$app->user->id])->count();

    }

    public static function setMessagesOpened($userId){

         $messages = Messages::find()->where(['senderId' => Yii::$app->user->id, 'receiverId' => $userId, 'opened' => 0])->orWhere(['senderId' => $userId, 'receiverId' => Yii::$app->user->id, 'opened' => 0])->all();

         foreach ($messages as $message) {
              if($message->senderId != Yii::$app->user->id){
                   $message->opened = 1;
                   $message->save();
              }
         }

    }

}

?>
