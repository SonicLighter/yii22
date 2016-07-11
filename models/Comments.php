<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $postId
 * @property string $message
 *
 * @property Posts $post
 * @property Users $user
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'postId', 'message'], 'required'],
            [['userId', 'postId'], 'integer'],
            [['message'], 'string'],
            [['postId'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['postId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'postId' => 'Post ID',
            'message' => 'Message',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'postId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userId']);
    }

    public static function getDataProvider(){

          $query = Comments::find()->where(['userId' => Yii::$app->user->getId()])->orderBy('id DESC');

          $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 5,
               ],
          ]);

          return $dataProvider;

    }

}
