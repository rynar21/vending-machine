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
    <div class="card">
        <div class="pull-right text-right">
            <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div style="max-width:440px">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <div class="card">
        <?= GridView::widget([
            'tableOptions' => [
            'class' => 'table   table-bordered  table-hover ',
            ],
            'options' => [
                'class' => 'table-responsive',
            ],
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                'attribute' =>'sku',
                    'filterInputOptions' => [
                        'class'  => 'form-control',
                        'placeholder' => 'Type in some characters...'
                        ]
                ],
                [
                'attribute' =>'name',
                    'filterInputOptions' => [
                        'class'  => 'form-control',
                        'placeholder' => 'Type in some characters...'
                        ]
                ],
                [
                'attribute' =>'category',
                    'filterInputOptions' => [
                        'class'  => 'form-control',
                        'placeholder' => 'Type in some characters...'
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
                    return Html::a('view', ['/product/view','id' => $model->id]).' | '.Html::a('update', ['/product/update','id' => $model->id]);
                    }
                ],
            ],

        ]); ?>
    </div>


</div>
