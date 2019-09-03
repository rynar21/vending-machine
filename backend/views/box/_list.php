<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\Box;
use backend\models\BoxSearch;
use yii\data\ActiveDataProvider;
// use backend\models\BoxSearch;

/* @var $model common\models\Store */

/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
$searchModel = new BoxSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$model = new ActiveDataProvider([
    'query' =>Box::find()->where(['store_id' => $model->id])
]);



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
                      'item.name',
                      'item.product.sku',
                      // 'created_at:datetime',
                      // 'updated_at:datetime',
                      'item.price',
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
