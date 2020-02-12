<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SaleRecord */

$this->title = 'Create Sale Record';
// $this->params['breadcrumbs'][] = ['label' => 'Sale Records', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'box_id')->textInput() ?>

    <?= $form->field($model, 'item_id')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php //echo $this->render('_form', ['model' => $model,]); ?>

</div>
