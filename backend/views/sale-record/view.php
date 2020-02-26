<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\SaleRecord;
use common\models\Product;
use common\models\Item;
/* @var $this yii\web\View */
/* @var $model common\models\SaleRecord */

$this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Sale Records', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
// \yii\web\YiiAsset::register($this);
?>
<div class="sale-record-view">

    <h1></h1>
    <p>
        <?= Html::a('Open Box',
        ['#',
        // 'id' => $model->id
        ],
         [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to open this box?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'SKU',
                'format' => 'raw',
                'value' => function($model)
                {
                    return product::find()->where(['id'=>Item::find()->where(['id'=>$model->item_id])->one()->product_id])->one()->sku;
                }
            ],
            'text:text:Order number',
            'store_name',
            'box_code',
            'item_name',
            'store.name',
            'sell_price:currency',
            [
                'attribute'=>'cost',
                'format' => 'currency',
                'visible' => Yii::$app->user->can('admin'),
                'value' => function($model)
                {
                    return product::find()->where(['id'=>Item::find()->where(['id'=>$model->item_id])->one()->product_id])->one()->cost;
                }
            ],
            //'box_id',
            //'item_id',
            'unique_id',
            //'trans_id',
            //'status',
            [
                'attribute'=>'status',
                'format' => 'raw' ,
                'value' => function ($model)
                {
                    if ($model->status==SaleRecord::STATUS_SUCCESS) {
                        //return 'Success';
                        return '<span style="color:#11ff06">' .'Success'.'';
                    }
                    if ($model->status==SaleRecord::STATUS_FAILED) {
                        //return 'Failure';
                        return '<span style="color:#CD0000">' .'Failure'.'';
                    }
                    if ($model->status==SaleRecord::STATUS_PENDING) {
                        //return 'Failure';
                        return '<span style="color:#2a5caa">' .'Pending'.'';
                    }

                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>


</div>
