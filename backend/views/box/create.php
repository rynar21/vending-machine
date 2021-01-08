<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Box */

$this->title = 'Create Box';
// $this->params['breadcrumbs'][] = ['label' => 'Boxes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-create">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <div class="box-form">

    <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'store_id')->textInput(['disabled' => true]) ?>

            <div class="row">
                 <div class="col-sm-12">
                      <b> Box Code </b>
                  </div>
                  
                  <div class="col-sm-12">
                      <?= $form->field($model, 'code', [
                        'template' => '<div class="input-group"><span class="input-group-addon">'. $model->prefix .'</span>{input}</div>',
                        ])->textInput(['disabled' => true]) ?>

                    <?= $form->field($model, 'code')->hiddenInput()->label(false) ?>
                 </div>

            </div>

            <?php

            if (strlen($model->code) < 2)
            {
                $model->hardware_id = "0" . $model->code . "OK";
            }
            else
            {
                $model->hardware_id = $model->code . "OK";
            }

            ?>

            <?= $form->field($model, 'hardware_id')->textInput(['disabled' => false]) ?>
            <div class="row form-group">
                  <div class="col-sm-1 col-xs-3">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                  </div>
                  <div class="col-sm-1 col-xs-3">
                        <?= Html::a('Cancel', ['store/view', 'id'=> $model->store_id], ['class' => 'btn btn-danger']) ?>
                 </div>
            </div>

        <?php ActiveForm::end(); ?>

</div>


</div>
