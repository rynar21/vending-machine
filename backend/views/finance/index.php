<?php

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


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
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
