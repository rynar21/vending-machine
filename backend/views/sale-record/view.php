<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\SaleRecord;
use common\models\Product;
use common\models\Item;
use common\models\Queue;
/* @var $this yii\web\View */
/* @var $model common\models\SaleRecord */

$this->title = $model->order_number;
// $this->params['breadcrumbs'][] = ['label' => 'Sale Records', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
// \yii\web\YiiAsset::register($this);
?>
<div class="sale-record-view">

    <h1></h1>
    <p>
        <?= Html::a('Open Box', ['box/open_box', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'SKU',
                'format' => 'raw',
                'label' =>'Stock Keeping Unti (SKU)',
                'value' => function($model)
                {
                    return Product::find()->where(['id' => $model->item->product_id])->one()->sku;
                }
            ],
            'order_number:text:Order No.',
            'unique_id:text:Reference No.',
            'store_name',
            [
              'attribute'=>'image',
              'value'=> $model->product->imageUrl,
              'format'=>['image', ['width'=>'250', 'height'=>'250']],
              //['width'=>'400', 'height'=>'300']
            ],
            'box_code',
            'item_name',
            //'store_name',
            'sell_price:currency',
            //'box_id',
            //'item_id',

            [
                'attribute'=>'cost',
                'format' => 'currency',
                'visible' => Yii::$app->user->can('admin'),
                'value' => function($model)
                {
                    return Product::find()->where(['id' => $model->item->product_id])->one()->cost;
                }
            ],
            //'trans_id',
            //'status',
            [
                'attribute'=>'box  status',
                'format' => 'raw' ,
                'value' => function ($model)
                {
                    $queue_model = Queue::find()->where(['priority'=>$model->order_number])->one();
                    if ($queue_model) {
                        if ($queue_model->status == Queue::STATUS_WAITING) {
                            //return 'Success';
                            return '<span style="color:#2a5caa">' .'Waiting to open'.'';
                        }
                        if ($queue_model->status == Queue::STATUS_SUCCESS) {
                            //return 'Failure';
                            return '<span style="color:#11ff06">' .'Opened'.'';
                        }
                    }
                    return false;
                },
            ],
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
