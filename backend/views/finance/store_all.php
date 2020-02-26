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
// $this->params['breadcrumbs'][] = $this->title;  http://localhost/vending-machine/backend/web/finance/datecheck"
?>
<div class="store_all">

    <h1><?= Html::encode($this->title) ?></h1>


    <!--<form method="GET" action="#">
        <div class="col-lg-8">
           <div class="input-group" >
             <input name="store_name"  type="text" class="form-control" placeholder="Please enter your store name">
             <span class="input-group-btn">
               <button cclass="btn btn-default" name="submit" type="submit">Search</button>
             </span>
           </div><!-- /input-group -->
         <!--</div><!-- /.col-lg-6 -->
    <!--</form> -->
    <br/>
        <br/>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'date',
                'format' => 'raw',
                 'headerOptions' =>['class'=>'col-lg-2',],
                'visible' => Yii::$app->user->can('admin'),
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
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                   return Finance::find_store_one_finance_oneday($model['store_id'],$model['date'])['store_name'];
                }
            ],
            [
                'attribute'=>'manager',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                   return Finance::find_store_one_finance_oneday($model['store_id'],$model['date'])['store_manager'];
                }
            ],
            [
                'attribute'=>'Order Quantity',
                'format' => 'raw',
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                 return Finance::find_store_one_finance_oneday($model['store_id'],$model['date'])['quantity_of_order'];
                }
            ],
            [
                'attribute'=>'Total Earnings',
                'format' => 'currency',
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                return Finance::find_store_one_finance_oneday($model['store_id'],$model['date'])['total_earn'];
                }
            ],
            [
                'attribute'=>'Net Profit',
                'format' => 'currency',
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                    return Finance::find_store_one_finance_oneday($model['store_id'],$model['date'])['net_profit'];
                }
            ],
            //['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('', ['/sale-record/one_store_all_salerecord',
                  'store_id'=>$model['store_id'],'date'=>$model['date']],
                  ['class' => 'btn btn-sm  glyphicon glyphicon-eye-open']);
                }
            ],
        ],
    ]); ?>


</div>
