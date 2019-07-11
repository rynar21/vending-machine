<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
      <div class="col-md-4">
        <?= $form->field($model, 'box_id')->textInput() ?>
        <?= $form->field($model, 'store_id')->textInput() ?>
      </div>
      <div class="col-md-8">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Item Name') ?>
        <div class="row">
          <div class="col-md-12"><b>Item Price</b></div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <p style="font-size: 18px; margin-top: 5px; font-weight: bold;"> RM </p>
              <?= $form->field($model, 'price')->textInput()->label('') ?>
            </div>
        </div>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-1">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
      </div>
      <div class="col-md-1">
      <?= Html::a('Cancel', ['box/index'], ['class' => 'btn btn-danger']) ?>
      </div>
      <div class="col-md-10"></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<style>
#item-price{
  width:320px;
  margin-left: 40px;
  margin-top: -60px;
}
</style>
