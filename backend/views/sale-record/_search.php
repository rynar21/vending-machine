<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SaleRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['autocomplete' => 'off']
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'box_id') ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatus()) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
