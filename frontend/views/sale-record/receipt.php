<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Invoice';
?>

<div class="sale-record-receipt">
    <h1>
        Transaction Receipt
    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'trans_id',
            'item_id',
            'status',
            'store_id',
            'box_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
