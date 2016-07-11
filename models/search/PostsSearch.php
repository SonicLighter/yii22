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

class PostsSearch extends Posts{

     public $pageId;

     public function __construct($pageId){

          $this->pageId = $pageId;

     }

     public function rules(){

          return[
               [['id'], 'integer'],
               [['title', 'description', 'text', 'dateCreate', 'dateUpdate'], 'safe'],
          ];

     }

     public function scenarios(){

         return Model::scenarios();

     }

     public function search($params){

          $query = Posts::find()->where(['userId' => $this->pageId]);
          $dataProvider = new ActiveDataProvider([
               'query' => $query,
               'pagination' => [
                    'pageSize' => 10,
               ],
          ]);
          $dataProvider->setSort([
               'defaultOrder' => [
                    'id' => SORT_DESC,
               ],
               'attributes' => [
                    'id' => [
                         'asc' => ['id' => SORT_ASC],
                         'desc' => ['id' => SORT_DESC],
                    ],
                    'title' => [
                         'asc' => ['title' => SORT_ASC],
                         'desc' => ['title' => SORT_DESC],
                         'label' => 'Title Search',
                    ],
               ],
          ]);

          if(!($this->load($params) && $this->validate())){
               return $dataProvider;
          }

          $query->andFilterWhere(['like','title' , $this->title]);

          return $dataProvider;

     }

}

?>
