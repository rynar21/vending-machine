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
    <?php //echo Yii::$app->formatter->asDateTime($model->created_at);
        $auth = Yii::$app->authManager;
        if ($auth->checkAccess(Yii::$app->user->identity->id,'admin')) {
            $str =' ';
        }
        if (!$auth->checkAccess(Yii::$app->user->identity->id,'admin')) {
            $str ='none';
        }
    ?>
    <p>
        <?= Html::a('Open Box', ['box/open_box', 'id' => $model->id], ['class' => 'btn btn-sm btn-info' ,'style'=>"display:"."$str"]) ?>
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
                    return  $model->item->product->sku;
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
                    return $model->item->product->cost;
                }
            ],
            //'trans_id',
            //'status',
            [
                'attribute'=>'status',
                'label' => 'Order Status',
                'format' => 'raw' ,
                'value' => function ($model)
                {
                    if ($model->status == SaleRecord::STATUS_SUCCESS) {
                        //return 'Success';
                        return '<span style="color:#11ff06">' .'Success'.'';
                    }
                    if ($model->status == SaleRecord::STATUS_FAILED) {
                        //return 'Failure';
                        return '<span style="color:#CD0000">' .'Failure'.'';
                    }
                    if ($model->status == SaleRecord::STATUS_PENDING) {
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
