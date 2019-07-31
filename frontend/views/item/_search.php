<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">

    <?php /*$form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); */?>

    <?php $form = ActiveForm::begin(['action' => ['view', 'id'=> $model->store_id], 'method' => 'get',]); ?>
        <div class="col-sm-8 col-xs-8">
            <?= $form->field($model, 'name')
                    -> input('name')
                    -> textInput(['placeholder' => "Please enter your item name"])
                    -> label(false) ?>
        </div>
        <div class="col-sm-4 col-xs-4">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary form-group search_btn']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
