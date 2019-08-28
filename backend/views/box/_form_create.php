<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Box */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-form">

    <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'store_id')->textInput(['disabled' => true]) ?>

            <div class="row">
                 <div class="col-sm-12">
                      <b> Box Code </b>
                  </div>
                  <div class="col-sm-12">
                      <?= $form->field($model, 'code', [
                        'template' => '<div class="input-group"><span class="input-group-addon">'. $model->prefix .'</span>{input}</div>',
                        ])->textInput(['disabled' => true]) ?>

                    <?= $form->field($model, 'number')->hiddenInput()->label(false) ?>
                 </div>
            </div>

            <div class="row form-group">
                  <div class="col-sm-1 col-xs-3">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                  </div>
                  <div class="col-sm-1 col-xs-3">
                        <?= Html::a('Cancel', ['store/view', 'id'=> $model->store_id], ['class' => 'btn btn-danger']) ?>
                 </div>
            </div>

        <?php ActiveForm::end(); ?>

</div>
