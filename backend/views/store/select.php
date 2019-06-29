<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Stores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="store-select">
      <?php $form = ActiveForm::begin([ 'action' => ['index'], 'method' => 'get',  ]); ?>
      <?= $form->field($searchModel, 'store_name') ?>
      <div class="form-group">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
      </div>
      <?php ActiveForm::end(); ?>

      <div class="row">
          <div class="col-md-11"></div>
          <?= Html::a('Create Store', ['create'], ['class' => 'btn btn-success col-md-1 add']) ?>
      </div>

      <div class="row break"></div>

      <div class="row">
        <?php foreach($dataProvider->getModels() as $store):?>
          <div class="col-md-3">
            <div class="store thumbnail">
              <a href="<?=Url::base()?>/box/home?id=<?= $store->store_id ?>"><?= $store->store_name ?>
            </div>
          </div>
        <?php endforeach ?>
      </div>
</div>

<style>
.add{

}
.store{
  border: 1px solid black;
  width: 250px;
  padding: 5px;
  background: black;
  color: white;
  font-size: 20px;
  text-align: center;
}

.break{
    background-color:#DCDCDC;
    height:40px;
    background-image: linear-gradient(90deg,transparent, black, transparent);
    border: 0;
    box-shadow:0px 1px 3px #2B2B2B;
    padding: 5px 0px 2px 10px;
    margin: 20px 0;
    text-align: center;
}
</style>
