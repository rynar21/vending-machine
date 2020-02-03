<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveField;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- 添加产品： 只需要选择 Product Name 产品名称 -->
<div class="item-form">

        <!-- 运行 Yii ActiveForm 框架 -->
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
        <!-- 产品名称 -->

        <?php
        $str = Product::find()
        ->select(['sku as value', 'CONCAT_WS(" - ",name,sku) as  label' ,'id as id'])
        ->asArray()
        ->all(); ?>
            <?=
             $form->field($model, 'sku')->widget(\yii\jui\AutoComplete::classname(), [

                 'clientOptions' => [
                       'source' => $str,
                       'options' => ['class' => 'form-control'],
                      // 'minLength'=>'2',
                      'autoFill'=>true,
                               ],
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
                  <?= Html::a('Cancel', ['/store/view', 'id'=> $model->store_id],
                  ['class' => 'btn btn-danger',
                  'data-method' => 'POST',
                  'data-params' => [
                      'modify' => true,]
                  ]); ?>
              </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
