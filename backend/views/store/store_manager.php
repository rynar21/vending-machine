
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\Store */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="store-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['disabled' => true]) ?>
    <?php $str = User::find()
        ->select(['username as value', 'CONCAT_WS(" - ",email,username) as  label' ,'id as id'])
        ->asArray()
        ->all(); ?>
            <?=
             $form->field($model, 'username')->widget(\yii\jui\AutoComplete::classname(), [
                 'options' => [
                     'class' => 'form-control ',
                     'placeholder' => 'Please enter your username',
                 ],
                 'clientOptions' => [
                       'source'  => $str,
                      'autoFill' => true,
                               ],]); ?>
    <!-- 信息提交 -->
    <div class="row form-group">
        <div class="col-sm-1 col-xs-3">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
       </div>
        <div class="col-sm-1 col-xs-3">
              <?= Html::a('Cancel', ['/store/view','id' => $model->id], ['class' => 'btn btn-danger']) ?>
       </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
