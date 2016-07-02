<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\base\Model;
use app\models\User;
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

     // filter

     public function scenarios(){

         return Model::scenarios();

     }

     public function search($params){

         $query = User::find();

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
                      'asc' => ['COUNT(posts.id)' => SORT_ASC],
                      'desc' => ['COUNT(posts.id)' => SORT_DESC],
                      'label' => 'Posts count',
                 ],
                 //'country_id'
            ],
         ]);

         // load the search form data and validate
         if(!($this->load($params) && $this->validate())){
               $query->joinWith(['role']);
               $query->joinWith(['posts']);
               return $dataProvider;
         }

         $query->andFilterWhere(['id' => $this->id]);
         $query->andFilterWhere(['like','username' , $this->username]);
               //->andFilterWhere(['like','postCount' , $this->postCount]);

         // role filter
         $query->joinWith(['role' => function($q){
              $q->where('auth_assignment.item_name LIKE "%' . $this->userRole . '%"');
         }]);

         $query->joinWith(['posts' => function($q){
              $q->where('COUNT(posts.id) LIKE "%' . $this->postCount . '%"');
         }]);


         return $dataProvider;

     }

}

?>
