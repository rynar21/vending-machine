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

<div class="item-form">

        <!-- 运行 Yii ActiveForm 框架 -->
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
              <?php
                  $test = Product::find()
                    ->select(['name as value', 'name as  label','id as id'])
                    ->asArray()
                    ->all();?>
                    <?= AutoComplete::widget([
                          'name' => 'name',
                          'clientOptions' => [
                              'source' => $test,
                              'autoFill' => true,
                              // 'select' => new JsExpression("function( event, ui )) {
                              //     $('#product').val(ui.product.id);
                              //  }"),
                          ],
                      ]); ?>

              <?= Html::activeHiddenInput($model, 'id')?>


              <?php //echo $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->all(), 'id', 'name')); ?>
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
