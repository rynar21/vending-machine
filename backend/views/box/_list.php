<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\Box;
use yii\data\ActiveDataProvider;

/* @var $model common\models\Store */

/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/

$model = new ActiveDataProvider([
    'query' =>Box::find()->where(['store_id' => $model->id])
]);
?>


<div class="row">

        <?= GridView::widget([
                 'dataProvider' => $model,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      'id',
                      'code',
                      [
                          'attribute'=> 'status',
                          'value' => 'statusText'
                      ],
                      'item.name',
                      'created_at:datetime',
                      'updated_at:datetime',
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
