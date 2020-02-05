<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SaleRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'box_id')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'item_id')->textInput(['disabled' => true]) ?>



    <?= $form->field($model, 'status')->textInput(['disabled' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
