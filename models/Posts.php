<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use Yii;
//use bupy7\bbcode\BBCodeBehavior;

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

    public function rules()
    {
        return [
            [['userId', 'title', 'content', 'dateCreate', 'dateUpdate'], 'required'],
            [['userId'], 'integer'],
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
            'content' => 'Content',
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

    public static function getPagePosts($id){

         $query = Posts::find()->where(['userId' => $id])->orderBy('id DESC');

         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                 'pageSize' => 10,
              ],
         ]);

         return $dataProvider;

    }

    public static function getLoadCount($id){

         return Posts::find()->where(['userId' => $id])->orderBy('id DESC')->count()/10;

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
                 'pageSize' => 10,
              ],
         ]);

         return $dataProvider;

    }

}
