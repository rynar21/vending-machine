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

        <?= $form->field($model, 'code')->textInput(['disabled' => true]) ?>

        <div class="row form-group">
              <div class="col-sm-1 col-xs-3">
                    <?= Html::a('Save', ['box/save', 'id'=> $model->store_id], ['class' => 'btn btn-success']) ?>
              </div>
              <div class="col-sm-1 col-xs-3">
                    <?= Html::a('Cancel', ['store/view', 'id'=> $model->store_id], ['class' => 'btn btn-danger']) ?>
             </div>
        </div>



    <?php ActiveForm::end(); ?>

</div>
