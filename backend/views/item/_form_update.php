<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */

?>

<!-- 更改产品： 只可应许更改产品出售价格 -->
<div class="item-form">

        <!--运行 Yii ActiveForm 框架 -->
        <?php $form = ActiveForm::begin(); ?>

        <!-- 盒子 ID -->
        <div class="row f_label">
            <div class="col-sm-1">
                Box Code:
            </div>
            <?= $model->box->code ?>
        </div>

        <!-- 商店 ID -->
        <div class="row f_label">
            <div class="col-sm-1">
                Store ID:
            </div>
            <?= $model->store_id ?>
        </div>

        <!-- 强行下架产品 为不可出售 -->
        <p>
            <?= Html::a('Void Item', ['void', 'id'=> $model->id], ['class' => 'btn btn-danger pull-right']) ?>
        </p>

        <!-- 产品名称 -->
        <div class="row">
            <div class="col-sm-12">
                <!-- 产品名称 不可替换 或更改 -->
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
                  <!-- 保存按钮 -->
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
              </div>

              <div class="col-sm-1 col-xs-3">
                  <!-- 取消按钮 -->
                  <?= Html::a('Cancel', ['/store/view', 'id'=> $model->store_id], ['class' => 'btn btn-danger']) ?>
              </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
