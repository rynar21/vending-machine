<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\user;

/* @var $this yii\web\View */
/* @var $model common\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact')->textInput() ?>

    <?= $form->field($model, 'prefix')->textInput() ?>




    <?= $form->field($model, 'imageFile')->fileInput() ?>


    <!-- 信息提交 -->
    <div class="row form-group">
          <div class="col-sm-1 col-xs-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
          </div>

          <div class="col-sm-1 col-xs-3">
                <?= Html::a('Cancel', ['/store/index'], ['class' => 'btn btn-danger']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
