<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Box */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'box_code')->textInput() ?>

    <?= $form->field($model, 'box_status')->textInput() ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
