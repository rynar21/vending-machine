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
    <div class="card">
        <div class="pull-right text-right">
        <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a('Open All Boxes', ['box/open-all-box', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger',
            'data' => [
            'confirm' => 'Make sure to open all boxes?',
            'method' => 'post']]); ?>
        </div>

        <div style="max-width:440px">
            <?php   
                echo $model->name . "<br>";
                echo $model->address . PHP_EOL;
                //echo $this->render('/box/_search', ['model' => $boxSearch]); 
            ?>
        </div>
    </div>

    <div class=" alert alert-info " style="margin:0 0 12px">
            <p>
            Total Number of Empty Box(es): <b><?= $boxSearch->getEmptyBoxQuantity($model->id) ?></b>
            </p>
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
        // 'filterModel' => $boxSearch,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=> 'code',
                'label'=> 'Box',
                'format' => 'raw',
                'value' => function ($model)
                    {
                        return $model->boxcode . "<br>". $model->statusText;
                    }
            ],
            [
                'attribute' => 'name',
                'label'=> 'Item',
                'value' => 'product.name',
            ],
            // [
            //     'attribute' => 'name',
            //     'label'=> 'Last Item',
            //     'value' => function ($model)
            //         {
            //             return Box::last_item($model->store_id,$model->id);
            //         }
            // ],
            // [
            //     'attribute'=> 'status',
            //     'label' =>'Status',
            //     'value' => 'statusText',
            // ],
            'item.price:currency',
            // [
            //     // 'attribute'=>'Item History',
            //     'format' => 'raw' ,
            //     'visible' => Yii::$app->user->can('staff'),
            //     'value' => function ($model)
            //         {
            //             return Html::a('Edit Hardware ID', ['/box/update','id' => $model->id]).
            //             ' | '. Html::a('Item History', ['/store/box_item','box_id' => $model->id,'store_id' => $model->store_id]).
            //             ' | '. Html::a('Order History', ['/sale-record/store_onebox_allsalerecord','box_id' => $model->id,'store_id' => $model->store_id]);
            //         }
            // ],
            [
                'label'=>'Action',
                'format' => 'raw',
                'value' => function ($model)
                    {
                        return $model->action;
                    }
            ],
            ],
        ]); ?>
        </div>


</div>
