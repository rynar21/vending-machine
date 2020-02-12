<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use common\models\SaleRecord;
use common\models\Store;
use common\models\Item;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finances';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="store_all">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => ['store_id' => 1, 'date' => 45698456],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'date',
            [
                'attribute'=>'store name',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                   return Store::find()->where(['id'=>$model['store_id']])->one()->name;
                }
            ],
            [
                'attribute'=>'Quantity Of Order',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return SaleRecord::find()->where(['store_id'=>$model['store_id']])
                  ->andWhere(['between','created_at' ,strtotime($model['date']),(strtotime($model['date'])+86399)])
                  ->andWhere(['status' => 10])
                  ->count();
                }
            ],
            [
                'attribute'=>'Total Earn',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                    $total = Store::STATUS_INITIAL;
                    $stroe_model = SaleRecord::find()->where(['store_id'=>$model['store_id']])
                    ->andWhere(['status' => 10])
                    ->andWhere(['between','updated_at' ,strtotime($model['date']),(strtotime($model['date'])+86399)])->all();
                    foreach ($stroe_model as $model) {
                        $arr = $model->sell_price ;
                        $total += $arr;
                    }
                  return $total;
                }
            ],
            [
                'attribute'=>'Net Profit',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                    $total = Store::STATUS_INITIAL;
                    $cost_price = Store::STATUS_INITIAL;
                    $stroe_model = SaleRecord::find()->where(['store_id'=>$model['store_id']])
                    ->andWhere(['status' => 10])
                    ->andWhere(['between','created_at' ,strtotime($model['date']),(strtotime($model['date'])+86399)])->all();
                    foreach ($stroe_model as $s_model) {
                        $total += $s_model->sell_price;
                        $cost_price += Product ::find()->where(['id'=>Item::find()->where(['id'=>$s_model->item_id])->one()->product_id])->one()->cost;

                    }
                    $net_profit = $total - $cost_price;
                    return $net_profit;
                }
            ],
            //['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('', ['finance/index'], ['class' => 'btn btn-sm  glyphicon glyphicon-eye-open']);
                }
            ],
        ],
    ]); ?>


</div>

<br />

<?php
// $date = '2020-02-09';
//
//
//      echo "\n";
//      $catime = strtotime($date);//
//      echo "\n";
//      echo $catime;

?>
