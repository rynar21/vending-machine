<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
               'attribute' =>'sku',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search...'
                    ]
            ],
            [
               'attribute' =>'name',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search...'
                    ]
            ],
            [
               'attribute' =>'category',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search...'
                    ]
            ],
            //'category',
            'price:currency',
            'cost:currency',
            [
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('view', ['/product/view','id'=>$model->id]).' | '.Html::a('update', ['/product/update','id'=>$model->id]);
                }
            ],
        ],

    ]); ?>


</div>
