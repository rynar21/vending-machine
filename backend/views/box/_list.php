<?php
use common\models\Store;
use common\models\Box;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
/* @var $model common\models\Store */

$model = new ActiveDataProvider([
    'query'=> Box::find()->where(['store_id' => 1]),
]);

/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>

<div class="row" >

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
              // [
              //     'label'=>'Action',
              //     'format'=>'raw',
              //     'value' => function($url, $model)
              //     {
              //         return Html::a('Modify Item', ['/item/update', 'id' => $model->item->id]);
              //     },
              // ],
              [
                  'class' => 'yii\grid\ActionColumn',
                  'template' => '{view} | {update}',
                  'buttons' =>
                  [
                      'view' => function($url, $model) {
                          return Html::a('view', ['/item/view', 'id' => $model->item->id]);
                      },
                      'update' => function($url, $model) {
                          return Html::a('update', ['/box/update', 'id' => $model->id]);
                      }
                  ],
              ],
          ],
      ]); ?>

</div>
