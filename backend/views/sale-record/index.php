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

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'tableOptions' => [
        'class' => 'table   table-bordered  table-hover ',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'options' =>['id'=>'grid'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',],
            [
                'attribute' =>'order_number',
                'filterInputOptions' => [
                   'class'  => 'form-control',
                   'placeholder' => 'Search....'
                ]
            ],
            // [
            //    'attribute' =>'box_code',
            //    //'headerOptions' =>['class'=>'col-lg-6',],
            //        'filterInputOptions' => [
            //            'class'  => 'form-control',
            //            'placeholder' => 'Search....'
            //         ]
            // ],
            'box_code:text:Box Code',
            // [
            //   'label' => 'Store',
            //   'attribute' => 'storename',
            //   'value' => 'store.name',
            //   'filterInputOptions' => [
            //       'class'  => 'form-control',
            //       'placeholder' => 'Search....'
            //    ]
            // ],
            [
              'label' => 'Item',
              'attribute' => 'itemname',
              'value' => 'item.name',
              'filterInputOptions' => [
                  'class'  => 'form-control',
                  'placeholder' => 'Search....'
               ]
            ],
            'sell_price:currency',
            [
               'attribute' =>'unique_id',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search....'
                    ]
            ],
            [
                'attribute'=>'status',
                'format' => 'raw' ,
                'headerOptions' =>['class'=>'col-sm-2',],
                'value' => function ($model)
                {
                    if ($model->status == SaleRecord::STATUS_SUCCESS) {
                        //return 'Success';
                        return '<span style="color:#11ff06">' .'Success'.'';
                    }
                    if ($model->status == SaleRecord::STATUS_FAILED) {
                        //return 'Failure';
                        return '<span style="color:#CD0000">' .'Failure'.'';
                    }
                    if ($model->status == SaleRecord::STATUS_PENDING) {
                        //return 'Failure';
                        return '<span style="color:#2a5caa">' .'Pending'.'';
                    }

                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status', [SaleRecord::STATUS_PENDING => 'Pending', SaleRecord::STATUS_SUCCESS => 'Success', SaleRecord::STATUS_FAILED => 'Failed'],
                    ['class'=>'form-control ','prompt' => 'All']),
            ],
            //'unique_id',
            'created_at:datetime:Order Time',
            // 'updated_at:datetime:Payment Time',
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                  return Html::a('view', ['sale-record/view', 'id' => $model->id]);
                }
            ],
        ],

    ]);
     ?>


</div>
