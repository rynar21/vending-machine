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
            'export',
            'store_id' => $searchModel->store_id,
            'item_id' => $searchModel->item_id,
            'status' => $searchModel->status,
            'time_start'    => $searchModel->time_start,
            'time_end'  => $searchModel->time_end
        ],
        [
            'class' => 'btn btn-success'
        ]); ?>
    </div>

    <div class="pms-log-search"style="max-width:440px">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['autocomplete' => 'off']
        ]); ?>

        <?= $form->field($searchModel, 'status',['labelOptions'=>['label'=>'Status']])->dropDownList($searchModel->getStatuses()) ?>        

        <?= $form->field($searchModel, 'item_id',['labelOptions'=>['label'=>'Item']])->dropDownList($searchModel->getItems()) ?>

        <?= $form->field($searchModel, 'store_id',['labelOptions'=>['label'=>'Store']])->dropDownList($searchModel->getStores()) ?>

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
    Total  Actual Amount: <b>RM <?= $actual_amount ?></b>
    <br>
    Total Number of Transaction: <b><?= $total_transaction ?></b>
    </div>
    <?= GridView::widget([
        'summary' => "Showing {begin} - {end} of {totalCount} items.",
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'order_number',
            'sell_price:text:Amount',
            'item.name:text:Item',
            'store.name:text:Store',
            'updated_at:datetime:Payment Time',
        ],
    ]); ?>
    </div>
    

</div>
