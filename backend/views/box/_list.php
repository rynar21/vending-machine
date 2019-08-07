<?php
use common\models\Item;
use common\models\Box;
use backend\models\BoxSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

/* @var $model common\models\Store */

/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/

// $searchModel = new BoxSearch();
// $searchModel->store_id = $model->id;
// $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$query = Box::find()->andFilterWhere([
    'store_id' => $model->id,
]);
// add conditions that should always apply here
$dataProvider = new ActiveDataProvider([
    'query' => $query,
]);
?>


<div class="row">

        <?= GridView::widget([
                 'dataProvider' => $dataProvider,
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
