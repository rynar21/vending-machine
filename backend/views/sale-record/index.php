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
// $this->params['breadcrumbs'][] = $this->title;
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
            'box_code:text:Box Code',
            // [
            //     'attribute'=>'Box number',
            //     'format' => 'raw' ,
            //     'value' => function ($model)
            //     {
            //         Box::find()->where(['id'=>$model->box_id])->one()->boxcode;
            //     },
            // ],
            'store_name:text:Store Name',
            'item_name:text:Item Name',
            // 'trans_id',
            //'status',
            'sell_price:currency',
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
            //'unique_id',
            'created_at:datetime:Creation time',
            'updated_at:datetime:End Time',
            [   'class' => 'yii\grid\ActionColumn',
                'header' => 'Action' ,
                'visible' => Yii::$app->user->can('admin'),
                'template' => ' {view}',
            ],
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
