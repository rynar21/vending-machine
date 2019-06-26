<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Operator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'operator_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'operator_password')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
