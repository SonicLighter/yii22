<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\base\Model;
use app\models\User;
use Yii;

class UserSearch extends User{

     public function rules(){

          return[
               [['id'], 'integer'],
               [['username', 'role'], 'safe'],
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
                     'asc' => ['username'=>SORT_ASC],
                     'desc' => ['username' => SORT_DESC],
                     'default' => false,
                 ],
                 //'country_id'
            ],
         ]);

         // load the search form data and validate
         if(!($this->load($params) && $this->validate())){
               return $dataProvider;
         }

         $query->andFilterWhere(['id' => $this->id]);
         $query->andFilterWhere(['like','username' , $this->username])
               ->andFilterWhere(['like','role' , $this->role]);

         return $dataProvider;

     }

}

?>
