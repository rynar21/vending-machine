<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-index container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'price',
            ['attribute'=> 'status', 'value' => 'statusText'],
            'created_at:datetime',
            'updated_at:datetime',
            'box_id',
            'store_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
