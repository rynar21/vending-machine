<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="store-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update Store', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete Store', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this Store?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>



    <?php //DetailView::widget([
        // 'model' => $model,
        // 'attributes' => [
        //     'id',
        //     'name',
        //     'address',
        //     'contact',
        //     'created_at:datetime',
        //     'updated_at:datetime',
        // ],
  //  ]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'code',
            'status',
            // 'store_id',
            'item.id',
            'created_at:datetime',
            'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <div class="containter">

    </div>



</div>
