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

    <!-- Purchased Item Information -->
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

    <br/>

    <table class="table" style="width:100%;">
          <tr>
              <?php foreach ($model->attributes() as $th):?>
              <th>
                  <?= $model->getAttributeLabel($th) ?>
              </th>
                <?php print_r(getValue($model, $th)) ?>
              <?php endforeach;?>
          </tr>

          <tr>
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
}

table, th, td {
  border: 1px solid black;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

</style>
