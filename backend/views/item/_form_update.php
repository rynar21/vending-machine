<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */

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

        <p>
            <?= Html::a('Void Item', ['void', 'id'=> $model->id], ['class' => 'btn btn-danger pull-right']) ?>
        </p>

        <!-- 产品名称 -->
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'name')->textInput(['disabled' => true])->label('Item Name') ?>
            </div>
        </div>

        <!-- 产品价格 -->
        <div class="row">
             <div class="col-sm-12">
                  <b>Item Price</b>
              </div>
              <div class="col-sm-12">
                  <?= $form->field($model, 'price', [
                    'template' => '<div class="input-group"><span class="input-group-addon">RM </span>{input}</div>',
                    ]); ?>
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