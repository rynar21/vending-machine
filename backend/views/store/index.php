<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Store';
?>

<div class="store-index">
    <div class="card">
        <div class="pull-right text-right">
            <?= Html::a('Create Store', ['create'], ['class' => 'btn btn-success','style'=>"display:"]) ?>
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'address',
            [
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('staff'),
                'value' => function ($model)
                {
                    return Html::a('Enter Store', ['/store/view','id' => $model->id]).' | '.Html::a('Modify Store Detail', ['/store/update','id' => $model->id]);
                }
            ],

        ],
    ]); 
    ?>
    </div>


</div>
