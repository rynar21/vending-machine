<?php

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\behaviors\AttributeBehavior;

$this->title = 'Invoice';
?>

<div class="sale-record-receipt">
    <h1>
        RECEIPT
    </h1>

    <p> Detail View </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'item_id',
            'status',
            'store_id',
            'box_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <hr/>

    <p> Grid View </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'header' => 'Quantity',
                'class' => 'yii\grid\SerialColumn',
            ],
            'id',
            'item.name',
            'store.name',
            [
                'attribute'=>'sell_price',
                'value' => 'pricing',
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

    <hr/>

    <p> Manual View </p>
    <table class="table" style="">
          <tr>
              <?php foreach ($model->attributes() as $th):?>
                  <th>
                      <?= $model->getAttributeLabel($th) ?>
                  </th>
              <?php endforeach;?>
          </tr>

          <tr>
              <td><?= $model->id ?></td>
              <td><?= Yii::$app->formatter->asDateTime($model->created_at) ?></td>
              <?php foreach ($model->getAttributes() as $tr):?>
                    <td>
                        <?= $tr ?>
                    </td>
                <?php endforeach;?>
          </tr>
    </table>

    <hr/>

    <table>

    </table>


</div>

<style>
table {
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

table, th, td {
  border: 1px solid black;
}

th>a{
    text-decoration: none;
    color: black;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

</style>
