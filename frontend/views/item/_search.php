<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">
    <?php $form = ActiveForm::begin(['id' => $id, 'action' => ['/store/view', 'id'=> $id], 'method' => 'get',]); ?>
        <div class="col-sm-8 col-xs-8">
            <?= $form->field($item_searchModel, 'name')
                    -> input('name')
                    -> textInput(['placeholder' => "Please enter your item name"])
                    -> label(false) ?>
        </div>
        <div class="col-sm-4 col-xs-4">
          <?= Html::submitButton('Search', ['class' => 'btn btn-primary form-group search_btn btn-block bt-search']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
