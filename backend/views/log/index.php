<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PmsLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';

?>
<div class="pms-log-index">
    <div class="card">
        <div class="pull-right text-right">
            <?= Html::a('Export',
            [
                'csv-export',
                'PmsLogSearch' =>
                [
                    'username' => $searchModel->username,
                    'type'  => $searchModel->type,
                    'action'    =>  $searchModel->action,
                    'time_start'    => $searchModel->time_start,
                    'time_end'  => $searchModel->time_end
                ]
            ],
            [
                'class' => 'btn btn-success'
            ]); ?>
        </div>

        <div style="max-width:440px">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <div class="card">
        <?= GridView::widget([
            'tableOptions' => [
            'class' => 'table table-bordered table-hover',
            ],
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'username',
                    'value' => 'user.username',
                    'filterInputOptions' => [
                        'class'  => 'form-control',
                        'placeholder' => 'Search....'
                     ]
                ],
                'type',
                'action',
                'updated_at:datetime',
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
            ],
        ]); ?>
    </div>    
</div>
