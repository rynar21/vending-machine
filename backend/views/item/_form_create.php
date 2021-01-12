<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Product;
use common\models\Box;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveField;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="row f_label">
                <div class="col-sm-1">
                    Box Code:
                </div>
                <?= $model->box->code ?>
            </div>

            <div class="row f_label">
                <div class="col-sm-1">
                    Store ID:
                </div>
                <?= $model->store_id ?>
            </div>

            <div class="row f_label">
                <div class="col-sm-1">
                    Last Item:
                </div>
                <?php $previous_item =  Box::PreviousItem($model->store_id,$model->box_id);
                    echo $previous_item['item_name'];
                ?>
            </div>
        </div>

            <?php $str = Product::find()
            ->select(['sku as value', 'CONCAT_WS(" - ",name,sku) as  label' ,'id as id'])
            ->asArray()
            ->all(); ?>
                <?=
                $form->field($model, 'sku')->widget(\yii\jui\AutoComplete::class, [
                    'options' => [
                        'class' => 'form-control ',
                        'placeholder' => 'Please enter your item name',
                         'value' => $previous_item['sku'],
                    ],
                    'clientOptions' => [
                            'name'   => '2',
                        'source'  => $str,
                        // 'minLength'=>'2',
                        'autoFill'=>true,
                                ],
                                ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?php // Html::a('Next', ['/item/create', 'id'=> $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Cancel', ['/store/view', 'id'=> $model->store_id], ['class' => 'btn btn-danger']) ?>
         
        </div>

    <?php ActiveForm::end(); ?>

</div>
