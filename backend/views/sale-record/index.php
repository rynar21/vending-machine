<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\SaleRecord;
use common\models\User;
use common\models\Box;
use yii\filters\AccessControl;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SaleRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
            'box_code:text:Box Code',
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
                        return '<span style="color:#11ff06">' .'Success'.'';
                    }
                    if ($model->status == SaleRecord::STATUS_FAILED) {
                        return '<span style="color:#CD0000">' .'Failure'.'';
                    }
                    if ($model->status == SaleRecord::STATUS_PENDING) {
                        return '<span style="color:#2a5caa">' .'Pending'.'';
                    }
                    if ($model->status == SaleRecord::STATUS_INIT) {
                        return '<span style="color:	#FFCC00">' .'INIT'.'';
                    }
                },
            ],
            'created_at:datetime:Order Time',
            [
                'attribute'=>'',
                'format' => 'raw' ,
                // 'visible' => Yii::$app->user->can('supervisor'),
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
