<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\User;
use common\models\Store;
use common\models\Item;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\Box;
use common\models\product;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

?>

<div class="store-view">
    <!-- 显示 店名为标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title);
            //echo $md;
            ?>
    </div>

    <!-- 显示商店拥有的盒子 -->
<div class="btn-group" role="group" aria-label="Second group">

    <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']) ?>
    <?php


    if ($model->status != Store::STATUS_IN_MAINTENANCE) {
        echo Html::a('Restock ', ['store/lockup_box','id' => $model->id ], ['class' => 'btn btn-sm btn-primary']);
    }
     ?>

    <?= Html::a('Open All Boxes', ['box/open_all_box', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger',
    'data' => [
        'confirm' => 'Make sure to open all boxes?',
        'method' => 'post']]) ?>
</div>

    <div class="col-sm-12">
        <div class="row">

                <?= GridView::widget([
                    'tableOptions' => [
                    'class' => 'table   table-bordered  table-hover ',
                    ],
                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $boxSearch,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label'=>'Action',
                            'format' => 'raw',
                            'value' => function ($model)
                                {
                                    return $model->action;
                                }
                        ],
                        [
                            'attribute'=> 'code',
                            'label'=> 'Box Code',
                            'format' => 'raw',
                            'headerOptions' =>['class'=>'col-lg-2',],
                            'value' => function ($model)
                                {
                                    return $model->boxcode;
                                }
                        ],
                        [
                            'attribute' => 'name',
                            'label'=> 'Item',
                            'value' => 'product.name',
                        ],
                        [
                            'attribute' => 'name',
                            'label'=> 'Last Item',
                            'value' => function ($model)
                                {
                                    return Box::last_item($model->store_id,$model->id);
                                }
                        ],
                        [
                            'attribute'=> 'status',
                            'label' =>'Status',
                            'value' => 'statusText',
                        ],
                        'item.price:currency',
                        [
                            // 'attribute'=>'Item History',
                            'format' => 'raw' ,
                            'headerOptions' =>['class'=>'col-lg-2',],
                            'visible' => Yii::$app->user->can('staff'),
                            'value' => function ($model)
                                {
                                    return Html::a('Edit Hardware ID', ['/box/update','id' => $model->id]).
                                    ' | '. Html::a('Item History', ['/store/box_item','box_id' => $model->id,'store_id' => $model->store_id]).
                                    ' | '. Html::a('Order History', ['/sale-record/store_onebox_allsalerecord','box_id' => $model->id,'store_id' => $model->store_id]);
                                }
                        ],
                        ],
                    ]); ?>
        </div>

        <div class="row">

            <div class="container-fluid">
                <div class="col-lg-12">
                    <?php
                    if ($model->status == Store::STATUS_IN_MAINTENANCE)
                    {
                        echo Html::a('Confirm', ['store/open_box', 'id' => $model->id], ['class' => 'pull-right col-lg-3  btn btn-lg btn-success ','style'=>"display:"."$str"]) ;
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>

    <div class="container-fluid">



    </div>

</div>
