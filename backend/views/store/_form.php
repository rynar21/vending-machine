<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\user;

/* @var $this yii\web\View */
/* @var $model common\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact')->textInput() ?>

    <?= $form->field($model, 'prefix')->textInput() ?>

    <?php
        $str = User::find()
        ->select(['id as value', 'CONCAT_WS(" - ",username,id) as label','id as id'])
        // ->where(['% 2 =', 'id', 1])
        ->asArray()
        ->all(); ?>


            <?=
             $form->field($model, 'user_id')->widget(\yii\jui\AutoComplete::classname(), [

                 'clientOptions' => [
                        // 'name'=>'2',
                       'source' => $str,
                       'options' => ['class' => 'form-control '],
                      // 'minLength'=>'2',
                      'autoFill'=>true,
                      // 'select' => new JsExpression("function( event, ui ) {
                      //               $('#item-id').val(ui.item.sku);
                      //            }"),
                               ],
                             ]);
                         ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>


    <!-- 信息提交 -->
    <div class="row form-group">
          <div class="col-sm-1 col-xs-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
          </div>

          <div class="col-sm-1 col-xs-3">
                <?= Html::a('Cancel', ['/store/index'], ['class' => 'btn btn-danger']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
