<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

$this->title = 'Error';
//var_dump($model->activeNew);
//die();
?>
<div class="site-about">

    <div class="row">
         <h1>Something went wrong!</h1>
         <h1>Why do you see this page? The answer is:</h1><br/>
         <p>
              1. User does not exist.
         </p>
         <p>
              2. User, which you are going to (add,delete,accept) (to,from) friends not exists already.
         </p>
         <p>
              3. User, which you are going to (delete,accept) (to,from) friends delete you from friends already.
         </p>
         <p>
              4. You are trying to delete comment by wrong id.
         </p>
         <p>
              5. You are trying to add comment to unknown post.
         </p>
         <p>
              6. You are trying to open dialog with unknown user.
         </p>
         <p>
              7. You are trying to dialog with yourself.
         </p>
    </div>

</div>
