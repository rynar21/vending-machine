<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';

?>
<div class="item-index ">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            ['attribute'=> 'price', 'value' => 'pricing'],
            ['attribute'=> 'status', 'value' => 'statusText'],
            'created_at:datetime',
            'updated_at:datetime',
            'product_id',
            'box_id',
            'store_id',
            ['class' => 'yii\grid\ActionColumn','header' => 'Action'],
        ],
    ]); ?>

</div>
