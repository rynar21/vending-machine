<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Finance */

$this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Finances', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
// \yii\web\YiiAsset::register($this);
?>
<div class="finance-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'quantity_of_order',
            'total_earn',
            'gross_profit',
            'net_profit',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
