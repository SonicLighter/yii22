<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\base\Model;
use app\models\User;
use app\models\Posts;
use Yii;

class UserSearch extends User{

     public $userRole;
     public $postCount;

     public function rules(){

          return[
               [['id'], 'integer'],
               [['username', 'userRole', 'postCount'], 'safe'],
          ];

     }

     public function scenarios(){

         return Model::scenarios();

     }

     public function search($params){

         $query = User::find();
         $subQuery = Posts::find()->select('userId, COUNT(userId) as post_count')->groupBy('userId');
         $query->leftJoin([
              'userPosts' => $subQuery,
         ], 'userPosts.userId=id');

         $dataProvider = new ActiveDataProvider([
             'query' => $query,
         ]);

         $dataProvider->setSort([
             'attributes'=>[
                 'id',
                 'username' => [
                     'asc' => ['username' => SORT_ASC],
                     'desc' => ['username' => SORT_DESC],
                     'label' => 'Name',
                     'default' => false,
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
         $query->andFilterWhere(['like','username' , $this->username]);

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
