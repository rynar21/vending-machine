<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\SaleRecord;

$this->title = 'Sale Records';
?>

<div class="sale-record-index">
    <div class="card">
        <div class="pull-right text-right">
            
        </div>

        <div style="max-width:440px">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <div class="card">
    <?= GridView::widget([
        'tableOptions' => [
        'class' => 'table   table-bordered  table-hover ',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',],
            'order_number',
            [
                'attribute'=>'Box Code',
                'format' => 'raw' ,
                'value' => function ($model)
                {
                  return $model->getBoxCode();
                }
            ],
            [
              'label' => 'Item',
              'attribute' => 'itemname',
              'value' => 'item.name',
            ],
            'sell_price:currency',
            'unique_id',
            [
                'attribute'=>'status',
                'format' => 'raw' ,
                'headerOptions' =>['class'=>'col-sm-2',],
                'value' => function ($model)
                {
                    if ($model->status == SaleRecord::STATUS_SUCCESS) {
                        return '<span class="text-success">' .'Success'.'</span>';
                    }
                    if ($model->status == SaleRecord::STATUS_FAILED) {
                        return '<span class="text-danger">' .'Failure'.'</span>';
                    }
                    if ($model->status == SaleRecord::STATUS_PENDING) {
                        return '<span class="text-primary">' .'Pending'.'</span>';
                    }
                    if ($model->status == SaleRecord::STATUS_INIT) {
                        return '<span class="text-warning">' .'INIT'.'</span>';
                    }
                },
            ],
            'created_at:datetime:Order Time',
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'value' => function ($model)
                {
                    return Html::a('view', ['sale-record/view', 'id' => $model->id]);
                }
            ],
        ],

    ]);
    ?>
    </div>


</div>
