<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\UploadedFile;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sku')->textInput() ?>
    <?= $form->field($model, 'category')->dropDownList($model->getCategories()) ?>
    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'cost')->textInput() ?>
    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <div class="form-group">
        <div class="col-sm-1 col-xs-3">
          <!-- 保存按钮 -->
          <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-sm-1 col-xs-3">
              <?= Html::a('Cancel', ['product/index'], ['class' => 'btn btn-danger']) ?>
       </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
