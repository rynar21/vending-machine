<?php
use common\models\Item;
use backend\models\BoxSearch;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $model common\models\Store */
// $model = new ActiveDataProvider([
//     'query'=> Box::find()->where(['store_id'=> $id]),
// ]);
// $model->store_id = $id;
// $model = Store::findOne(1);
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/

$searchModel = new BoxSearch();
$searchModel->store_id = $model->id;
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

?>


<div class="row">

        <?= GridView::widget([
                 'dataProvider' => $dataProvider,
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
