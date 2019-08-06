<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */

// $model: use common/models/Item
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>
        <!-- 盒子 ID -->
        <div class="row f_label">
            <div class="col-sm-1">
                Box ID:
            </div>
            <?= $model->box_id ?>
        </div>

        <!-- 商店 ID -->
        <div class="row f_label">
            <div class="col-sm-1">
                Store ID:
            </div>
            <?= $model->store_id ?>
        </div>

        <!-- 产品名称 -->
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'name')->dropDownlist([]) ?>
                <?php //$form->field($model, 'name')->textInput(['maxlength' => true])->label('Item Name') ?>
            </div>
        </div>

        <!-- 产品价格 -->
        <div class="row">
             <div class="col-sm-12">
                  <b>Item Price</b>
              </div>
              <div class="col-sm-12">
                    <p style="font-size: 18px; margin-top: 5px; font-weight: bold;">
                        RM
                    </p>
                    <?= $form->field($model, 'price')->textInput()->label('') ?>
              </div>
        </div>

        <!-- 提交表格按钮 -->
        <div class="row form-group">
              <div class="col-sm-1 col-xs-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
              </div>

              <div class="col-sm-1 col-xs-3">
                  <?= Html::a('Cancel', ['/store/view', 'id'=> $model->store_id], ['class' => 'btn btn-danger']) ?>
              </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
/* .f_label{
    margin: 10px 0px;
    font-size: 15px;
    color: #808080;
}

.f_label > .col-sm-1{
    padding: 0px;
    font-weight: bold;
}

#item-price{
  width:320px;
  margin-left: 40px;
  margin-top: -60px;
} */
</style>
