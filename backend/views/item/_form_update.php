<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="item-form">

        
        <?php $form = ActiveForm::begin(); ?>
        <!-- <div class="card">
            
        </div> -->

        <div class="card">
            <div class="pull-right text-right">
                <?= Html::a('Void Item', ['void', 'id'=> $model->id], ['class' => 'btn btn-danger pull-right']) ?>
            </div>

            <div style="max-width:440px">
                <div class="row f_label">
                    <b>
                        Box Code:
                    </b>
                    <?= $model->store->prefix . $model->box->code ?>
                </div>

                <div class="row f_label">
                    <b>
                        Store:
                    </b>
                    <?= $model->store->name ?>
                </div>
            </div>
        </div>

        <!-- 产品名称 -->
        <div class="row">
            <div class="col-sm-12">
                <!-- 产品名称 不可替换 或更改 -->
                <?= $form->field($model, 'name')->textInput(['disabled' => true])->label('Item Name') ?>
            </div>
        </div>

        <!-- 产品价格 -->
        <div class="row">
             <div class="col-sm-12">
                  <b>Item Price</b>
              </div>
              <div class="col-sm-12">
                  <?= $form->field($model, 'price', [
                    'template' => '<div class="input-group"><span class="input-group-addon">RM </span>{input}</div>',
                    ]); ?>
             </div>
        </div>

        <!-- 提交表格按钮 -->
        <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Cancel', ['/store/view', 'id'=> $model->store_id], ['class' => 'btn btn-danger']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
