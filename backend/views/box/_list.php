<?php
use common\models\Store;
use common\models\Box;
use common\models\Item;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $model common\models\Store */
$model = new ActiveDataProvider([
    'query'=> Box::find()->where(['store_id'=>1]),
]);
// $model = Store::findOne(1);
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>


<div class="row">
        <?= GridView::widget([
                 'dataProvider' => $model,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      'id',
                      'code',
                      ['attribute'=> 'status','value' => 'statusText'],
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
