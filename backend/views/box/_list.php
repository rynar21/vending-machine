<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\Box;
use common\models\Store;

use yii\data\ActiveDataProvider;
use backend\models\BoxSearch;

/* @var $model common\models\Store */

/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/

$searchModel = new BoxSearch([
    'store_id' => $this->store->id
    // $query=> Box::find()-> where(['store_id' =>$model->id])
]);

// $model = new ActiveDataProvider([
//      'query' =>$query
// ]);

$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 // $model->name=$
?>


<div class="row">

        <?= GridView::widget([
                 'dataProvider' => $dataProvider,
                 'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      // 'id',
                      [
                          'label'=> 'Box Code',
                          'format' => 'raw',
                          'value' => function ($model)
                          {
                              return $model->boxcode;
                          }
                      ],
                      [
                          'attribute'=> 'status',
                          'value' => 'statusText'
                      ],
                      // 'status',
                      [
                        'attribute' => 'name',
                        'value' => 'product.name'
                        ],
                      'item.price:currency',
                      // 'created_at:datetime',
                      // 'updated_at:datetime',
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
