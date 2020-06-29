<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use common\models\SaleRecord;
use common\models\Store;
use common\models\User;
use common\models\Item;
use common\models\Product;
use common\models\Finance;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finances';
?>
<div class="store_all">

    <h1><?= Html::encode($this->title) ?></h1>

    <br/>
        <br/>

    <?= GridView::widget([
        'tableOptions' => [
        'class' => 'table   table-bordered  table-hover ',
        ],
        'options' => [
            'class' => 'table-responsive ',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'date',
                'format' => 'raw',
                'headerOptions' =>['class'=>'col-lg-2',],
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                   return Yii::t('app', ' {0, date}', $model['date']) ;
                }
            ],
            //'store_id',
            // 'store_name',
            // 'manager',
            [
                'attribute'=>'store',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                   return Finance::financial_detail_inquiry($model['store_id'], $model['date'])['store_name'];
                }
            ],
            [
                'attribute'=>'manager',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                   return Finance::financial_detail_inquiry($model['store_id'], $model['date'])['store_manager'];
                }
            ],
            [
                'attribute'=>'Order Quantity',
                'format' => 'raw',
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                 return Finance::financial_detail_inquiry($model['store_id'], $model['date'])['quantity_of_order'];
                }
            ],
            [
                'attribute'=>'Total Earnings',
                'format' => 'currency',
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                return Finance::financial_detail_inquiry($model['store_id'], $model['date'])['total_earn'];
                }
            ],
            [
                'attribute'=>'Net Profit',
                'format' => 'currency',
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                    return Finance::financial_detail_inquiry($model['store_id'], $model['date'])['net_profit'];
                }
            ],
            //['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                  return Html::a('view', ['/sale-record/one_store_all_salerecord',
                  'store_id'=>$model['store_id'],'date' => $model['date']]);
                }
            ],
        ],
    ]); ?>


</div>
