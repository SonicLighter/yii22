<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\base\Model;
use app\models\User;
use app\models\Friends;
use app\models\Posts;
use yii\helpers\ArrayHelper;
use Yii;

class UserSearch extends User{

     public $userRole;
     public $postCount;
     public $type;

     public function __construct($value = 'users'){

          $this->type = $value;    // if users, then searching for users page, search for search page etc.

     }

     public function rules(){

          return[
               [['id'], 'integer'],
               [['username', 'userRole', 'postCount', 'email'], 'safe'],
          ];

     }

     public function scenarios(){

         return Model::scenarios();

     }

     public function search($params){

         switch ($this->type) {
              case 'search':
                   $query = User::find()->where(['active' => 1])->andWhere(['!=', 'id', Yii::$app->user->identity->id]);
                   break;
              case 'friends':
                   $query = User::find()->where(['id' => Friends::getUserFriends(1)]);
                   break;
              case 'requests':
                   $query = User::find()->where(['id' => ArrayHelper::getColumn(Friends::find()->where(['senderId' => Yii::$app->user->id, 'accepted' => 0])->all(), 'receiverId')]);
                   break;
              case 'waiting':
                   $query = User::find()->where(['id' => ArrayHelper::getColumn(Friends::find()->where(['receiverId' => Yii::$app->user->id, 'accepted' => 0])->all(), 'senderId')]);
                   break;
              default:
                   $query = User::find();
                   break;
         }

         //$query = User::find();
         $subQuery = Posts::find()->select('userId, COUNT(userId) as post_count')->groupBy('userId');
         $query->leftJoin([
              'userPosts' => $subQuery,
         ], 'userPosts.userId=id');

         $dataProvider = new ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                  'pageSize' => 10,
             ],
         ]);

         $dataProvider->setSort([
             'attributes'=>[
                 'id',
                 'email' => [
                     'asc' => ['email' => SORT_ASC],
                     'desc' => ['email' => SORT_DESC],
                     'label' => 'E-mail',
                 ],
                 'username' => [
                     'asc' => ['username' => SORT_ASC],
                     'desc' => ['username' => SORT_DESC],
                     'label' => 'Name',
                 ],
                 'userRole' => [
                      'asc' => ['auth_assignment.item_name' => SORT_ASC],
                      'desc' => ['auth_assignment.item_name' => SORT_DESC],
                      'label' => 'User Role',
                 ],
                 'postCount' => [
                      'asc' => ['userPosts.post_count' => SORT_ASC],
                      'desc' => ['userPosts.post_count' => SORT_DESC],
                      'label' => 'Posts Count',
                 ],
            ],
         ]);

         // load the search form data and validate
         if(!($this->load($params) && $this->validate())){
               $query->joinWith(['role']);
               return $dataProvider;
         }

         $query->andFilterWhere(['id' => $this->id]);
         $query->andFilterWhere(['like','username' , $this->username])
               ->andFilterWhere(['like','email' , $this->email]);

         // postFilter | refresh doesn't work...
         //$query->andWhere(['userPosts.post_count' => $this->postCount]);

         // role filter
         $query->joinWith(['role' => function($q){
              $q->where('auth_assignment.item_name LIKE "%' . $this->userRole . '%"');
         }]);

         return $dataProvider;

     }

}

?>
