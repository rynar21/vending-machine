
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use common\models\SaleRecord;
use common\models\Store;
use common\models\User;
use common\models\Item;
use common\models\Finance;
use common\models\Product;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Store::find()->where(['id' => $store_id])->one()->name . "'s Financial Records";
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-index">

    <?php  if (empty($dataProvider_all)) {
        $dataProvider_all = new ArrayDataProvider([
           'allModels' => array(),
       ]);
        }
        if (empty($dataProvider_date)) {
            $dataProvider_date = new ArrayDataProvider([
               'allModels' => array(),
           ]);
        }
        // if (empty($store_id)) {
        //     $store_id = null;
        // }
   ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row col-sm-12">
        <form method="GET" action="http://localhost/vending-machine/backend/web/finance/datecheck_store">
            <input name="date1"  type="date" min="2000-01-02"  class=" col-sm-2">
            <div class="col-sm-1 text-center">-</div>
            <input name="date2"  type="date" min="2000-01-02" class=" col-sm-2" >
            <input name="store_id" value="<?= $store_id?>"type="hidden"  >
            <input type="submit" name="submit" value="Search" class=" btn btn-sm btn-primary col-sm-1 ">
        </form>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider_all,
        //'filterModel' => '',
        'columns' => [
            [
                'attribute'=>'date',
                'headerOptions' =>['class'=>'col-lg-2',],
            ],
            [
                'attribute'=>'quantity_of_order',
                'label' => 'Order Quantity',
                'headerOptions' =>['class'=>'col-lg-2',],
            ],
            'total_earn:text:Total Earnings',
            'gross_profit',
            'net_profit',
            [
                'attribute'=>'export bill',
                'format' => 'raw' ,
                'headerOptions' =>['class'=>'col-lg-1',],
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('', ['finance/export_data_one_store','date'=>$model['date'],'store_id'=>$model['store_id']],
                   ['class' => 'glyphicon glyphicon-download-alt']);
                }
            ],
            [
                'attribute'=>'export order',
                'format' => 'raw' ,
                'headerOptions' =>['class'=>'col-lg-1',],
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('', ['finance/export_order_onestore','date'=>$model['date'],'store_id'=>$model['store_id']], ['class' => 'glyphicon glyphicon-download-alt']);
                }
            ],
        ],
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider_date,
        'filterModel' => '',
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
            'store_name:text:Store',
            'quantity_of_order:text:Order Quantity',
            'total_earn:currency:Total Earnings',
            'gross_profit:currency',
            'net_profit:currency',
            //'net_profit:currency',
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
