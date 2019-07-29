<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\data\BaseDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['action' => ['index'], 'method' => 'get',]); ?>
      <?= $form->field($searchModel, 'name') ?>
      <div class="form-group">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
          <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
      </div>
    <?php ActiveForm::end(); ?>

    <div class="row" style="
    background-color:#DCDCDC;
    height:40px;
    background-image: linear-gradient(90deg,transparent, #CDB7B5, transparent);
    border: 0;
    box-shadow:0px 1px 3px #2B2B2B;
    padding: 5px 0px 2px 10px; margin: 10px 0;
    text-align: center;
    ">
      <h4>FEATURED</h4>
    </div>

    <div class="row">
      <?php foreach ($item_model->getModels() as $item):?>
        <div class="col-lg-1 col-md-2"></div>
        <div class=" col-lg-3 col-md-2">
          <div style="border:2px solid black; width:70px; padding: 10px;">
            <?= Html::a($item->name, ['payment?id='.$item->id], ['class' => 'btn btn-success']) ?>
          </div>
        </div>
      <?php endforeach ?>
    </div>

</div>
