<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\data\BaseDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="item-index" style=" border:0px solid red;" >
  <div class="body-content">




      <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Link with href
      </a>
      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Button with data-target
      </button>
      <div class="collapse" id="collapseExample" >
        <div class="well" style="height:500px;">
          ...  <button type="button" class="btn btn-primary col-md-1" id="<?=$model->id?>" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> pay</button>
              <?= Html::a('index',['item/ok', 'id' => $model->id,])?>
        </div>
      </div>


  </div>
</div>
