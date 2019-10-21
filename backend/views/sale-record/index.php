<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\SaleRecord;



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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'options' =>['id'=>'grid'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
            // 'name'=>'id',
            ],
           'text:text:Order number',
            'box_id:text:Box number',
            'item_id:text:Item number',
            'store_id:text:Store number',
            // 'trans_id',
            //'status',
            [
                'attribute'=>'status',
                'format' => 'raw' ,
                'value' => function ($model)
                {
                    if ($model->status==SaleRecord::STATUS_SUCCESS) {
                        //return 'Success';
                        return '<span style="color:#11ff06">' .'Success'.'';
                    }
                    if ($model->status==SaleRecord::STATUS_FAILED) {
                        //return 'Failure';
                        return '<span style="color:#CD0000">' .'Failure'.'';
                    }
                    if ($model->status==SaleRecord::STATUS_PENDING) {
                        //return 'Failure';
                        return '<span style="color:#2a5caa">' .'Pending'.'';
                    }

                },
            ],
            'created_at:datetime:Creation time',
            'updated_at:datetime:End Time',
            ['class' => 'yii\grid\ActionColumn','header' => 'Action'],
        ],

        // 'rowOptions'=>function($model){
        //     if($model->status == 10){
        //         return
        //         // 'contentOptions' => ['style'=>'color:green;'];
        //          ['style'=>'color:green;'];
        //
        //     }
        //     if ($model->status==8) {
        //         return ['style'=>'color:red;'];
        //     }
        //     },
    ]);
     ?>


</div>
