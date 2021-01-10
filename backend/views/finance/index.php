<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Financial Records';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-index">

      
    <div class="pull-right text-right">
        <?= Html::a('Export',
        [
            'export',
            //'car_plate_number' => $searchModel->car_plate_number,
           // 'username' => $searchModel->username,
            //'time_start'    => $searchModel->time_start,
            //'time_end'  => $searchModel->time_end
        ],
        [
            'class' => 'btn btn-success'
        ]); ?>
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
