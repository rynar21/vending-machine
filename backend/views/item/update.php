<?php

use yii\helpers\Html;
use app\assets\AppAsset;
/* @var $this yii\web\View */
/* @var $model common\models\Item */
$this->title = 'Update Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="item-update">
    <h1 class="row col-md-12"><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
    <hr class="row"/>
    <div class="row">
      <h3 class="col-md-12">Current Box(es):</h3>
    </div>
    <div class="row">
      <?php
        // Print Item ID which is sold
        print_r($model->record->item_id);
        ($model->id)."<br>";
        // Print Item Name which is sold
        if (($model->id)!==($model->record->item_id))
        {
          echo $model->name;
        };
      ?>
    </div>


</div>
