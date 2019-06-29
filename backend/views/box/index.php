<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BoxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Boxes';
$this->params['breadcrumbs'][] = $this->title;
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="box-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Box', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'filterModel' => $searchModel2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'box_id',
            'box_code',
            'box_status',
            'store_id',
            'stores.store_name',
            'items.name',
            'items.id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
