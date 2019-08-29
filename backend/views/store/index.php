<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="store-index">
<!-- 标题 -->
    <h1 ><?= Html::encode($this->title) ?></h1>

    <!-- 创建 新商店 -->
    <p>
        <?= Html::a('Create Store', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <!-- 商店列表 -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'name',
            'address',
            'contact',
            // 'created_at:datetime',
            // 'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn', 'header' => 'Action'],
        ],
    ]); ?>

</div>
