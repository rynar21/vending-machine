<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Finance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity_of_order')->textInput() ?>

    <?= $form->field($model, 'total_earn')->textInput() ?>

    <?= $form->field($model, 'gross_profit')->textInput() ?>

    <?= $form->field($model, 'net_profit')->textInput() ?>

    <?php //echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
