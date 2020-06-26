<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Records';

?>
<div class="item-index ">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'tableOptions' => [
        'class' => 'table   table-bordered  table-hover ',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
             'name',
             'price:currency',
             ['attribute'=> 'status', 'value' => 'statusText'],
             'created_at:datetime:Creation Time',
             [
                 'attribute'=>'information',
                 'format' => 'raw' ,
                 'visible' => Yii::$app->user->can('admin'),
                 'value' => function ($model)
                 {
                   return Html::a('view', ['/product/view','id'=>$model->product_id]);
                 }
             ],
        ],
    ]); ?>

</div>
