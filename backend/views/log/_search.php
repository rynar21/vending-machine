<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\PmsLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['autocomplete' => 'off']
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'type')->dropDownList($model->getTypes()) ?>

    <?= $form->field($model, 'action')->dropDownList($model->getActions()) ?>

   <div class="form-inline">
        <?= $form->field($model, 'time_start')->widget(DatePicker::class, ['options' => ['class' => 'form-control', 'placeholder' => 'Start Date']])->label(false) ?>
        &nbsp; <i class="fas fa-minus"></i> &nbsp;
        <?= $form->field($model, 'time_end')->widget(DatePicker::class, ['options' => ['class' => 'form-control', 'placeholder' => 'End Date']])->label(false) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
