<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="store-index">

    <!-- 标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <!-- 创建 新商店 -->
    <div class="row">
        <div class="col-sm-12">
            <?= Html::a('Create Store', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <!-- 商店列表 -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'address',
            'contact',
            'created_at:datetime',
            'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
