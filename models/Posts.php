<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $dateCreate
 * @property string $dateUpdate
 *
 * @property Users $user
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'title', 'description', 'text', 'dateCreate', 'dateUpdate'], 'required'],
            [['userId'], 'integer'],
            [['description', 'text'], 'string'],
            [['title', 'dateCreate', 'dateUpdate'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
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
            'title' => 'Title',
            'description' => 'Description',
            'text' => 'Text',
            'dateCreate' => 'Date Create',
            'dateUpdate' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public static function getDataProvider(){

          $query = Posts::find()->where(['userId' => Yii::$app->user->getId()])->orderBy('id DESC');

          $dataProvider = new ActiveDataProvider([
              'query' => $query,
              'pagination' => [
                  'pageSize' => 5,
               ],
          ]);

          return $dataProvider;

    }

    public static function getCurrentPost($postId){

         return Posts::find()->where(['userId' => Yii::$app->user->id, 'id' => $postId])->one();

    }

    public static function getUserPost($userId, $postId){

         return Posts::find()->where(['userId' => $userId, 'id' => $postId])->one();

    }

    public function beforeDelete(){

         if(parent::beforeDelete()){
             Comments::deleteAll(['postId' => $this->id]);  // deleting all comments before post
             return true;
         }
         else{
              return false;
         }

    }

    // Comments
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['postId' => 'id']);
    }

    public function getCommentsCount(){

         return count($this->comments);

    }

    public function getPostComments(){

         $query = Comments::find()->where(['postId' => $this->id]);

         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                 'pageSize' => 2,
              ],
         ]);

         return $dataProvider;

    }

}
