<?php

use yii\helpers\Html;
use yii\grid\GridView;



/* @var $this yii\web\View */
/* @var $searchModel backend\models\SaleRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sale Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-record-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php Html::a('Create Sale Record', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            // [
            //     'label'=>'TransactionNumber',
            //     'format'=>'raw',
            //     'value'=>function($model)
            //     {
            //         return date('Y/m/d',$model->created_at).'_'.$model->id;
            //     }
            // ],
            'transactionNumber',
            'box_id',
            'item_id',
            'store_id',
            // 'status',
            [
                'attribute'=> 'status',
                'value'=> 'statusText'
            ],
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn','header' => 'Action'],
        ],
    ]); ?>


</div>
