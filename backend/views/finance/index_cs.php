<?php
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finances';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row col-sm-12">
        <form method="GET" action="<?= Yii::getAlias('@urlFrontend/payment/check?id=');?><?= Url::to(['finance/datecheck'])?>">
            <input name="date1"  type="date" class=" col-sm-2">
            <div class="col-sm-1 text-center">-</div>
            <input name="date2"  type="date"  class=" col-sm-2" >
            <input type="submit" name="submit" value="ok" class=" btn btn-sm btn-primary col-sm-1 ">
        </form>
    </div>
    <?php  if (empty($dataProvider_all)) {
        $dataProvider_all = new ArrayDataProvider([
           'allModels' => array(),
       ]);
    }?>
    <?= GridView::widget([
        'tableOptions' => [
        'class' => 'table   table-borderless  table-hover ',
        ],
        'options' => [
            'class' => 'table-responsive ',
        ],
        'dataProvider' => $dataProvider_all,
        //'filterModel' => '',
        'columns' => [
            'date',
            'quantity_of_order',
            'total_earn',
            'gross_profit',
            'net_profit',
        ],
    ]); ?>

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
            'date',
            'quantity_of_order',
            'total_earn:currency',
            'gross_profit:currency',
            'net_profit:currency',
            //['class' => 'yii\grid\ActionColumn'],
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('', ['finance/store_all','date'=>$model->date], ['class' => 'btn btn-sm  glyphicon glyphicon-eye-open']);
                }
            ],
        ],
    ]); ?>


</div>
