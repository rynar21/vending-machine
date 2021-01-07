<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Records';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-index">

    <div class="card">

    <div class="pull-right text-right">
        <?= Html::a('Export',
        [
            'export-payment',
            //'car_plate_number' => $searchModel->car_plate_number,
           // 'username' => $searchModel->username,
            //'time_start'    => $searchModel->time_start,
            //'time_end'  => $searchModel->time_end
        ],
        [
            'class' => 'btn btn-success'
        ]); ?>
    </div>

    <div class="pms-log-search"style="max-width:440px">
        <?php $form = ActiveForm::begin([
            'action' => ['payment'],
            'method' => 'get',
            'options' => ['autocomplete' => 'off']
        ]); ?>

        <?= $form->field($searchModel, 'order_number') ?>

        <?= $form->field($searchModel, 'store_id') ?>

        <div class="form-inline">
            <?= $form->field($searchModel, 'time_start')->widget(DatePicker::class, ['options' => ['class' => 'form-control', 'placeholder' => 'Start Date']])->label(false) ?>
            &nbsp; <i class="fas fa-minus"></i> &nbsp;
            <?= $form->field($searchModel, 'time_end')->widget(DatePicker::class, ['options' => ['class' => 'form-control', 'placeholder' => 'End Date']])->label(false) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    </div>
    <div class=" alert alert-info" style="margin:0 0 12px">
    Total Amount Received: <b>RM <?= $total_amount ?></b>
    <br>
    Total Number of Transaction: <b><?= $total_transaction ?></b>
    </div>
    <div class="card">
    <?= GridView::widget([
        'summary' => "Showing {begin} - {end} of {totalCount} items.",
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'car_plate_number',
            'amount',
            [
                'attribute' => 'username',
                'value' => function ($model) {
                    return $model->getUserName();
                },
            ],
            'updated_at:datetime:Payment Time',
        ],
    ]); ?>
    </div>
    

</div>
