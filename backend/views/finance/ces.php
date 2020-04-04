<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use common\models\SaleRecord;
use common\models\Store;
use common\models\User;
use common\models\Item;
use common\models\Product;
use common\models\Finance;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Records';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row col-sm-12">
        <form method="GET" action="<?= Url::to(['finance/datecheck'])?>">
            <input name="date1"  type="date" min="2000-01-02"  class=" col-sm-2">
            <div class="col-sm-1 text-center">-</div>
            <input name="date2"  type="date" min="2000-01-02" class=" col-sm-2" >
            <input type="submit" name="submit" value="Search" class=" btn btn-sm btn-primary col-sm-1 ">
        </form>
    </div>
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

   ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider_all,
        //'filterModel' => '',

        'columns' => [

            //'date',
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
                'attribute'=>'Export Statement',
                'format' => 'raw' ,
                'headerOptions' =>['class'=>'col-lg-1',],
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('Download', ['finance/export_data','date'=>$model['date']]);
                }
            ],
            [
                'attribute'=>'export order',
                'format' => 'raw' ,
                'headerOptions' =>['class'=>'col-lg-1',],
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('Download', ['finance/export_order','date'=>$model['date']]);
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
            'quantity_of_order:text:Order Quantity',
            'total_earn:currency:Total Earnings',
            'gross_profit:currency',
            'net_profit:currency',
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('view', ['finance/store_all','date'=>$model['date']]);
                }
            ],
        ],
    ]); ?>


</div>
