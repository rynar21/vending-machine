<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-index container">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'price',
            'box_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <div class="row">

      <?php foreach ($dataProvider->getModels() as $item): ?>
        <?php foreach ($dataProvider2->getModels() as $trans): ?>
        <?php
            $item->name;
            $trans->item_id;
            echo "<br>";
            if ($trans->item_id == $item->id)
            {
              echo $item->name;
            }
        ?>
        <?php endforeach ?>
      <?php endforeach ?>


      <?php
        // Print Item ID which is sold

        echo "<br>";
        // // Print Item Name which is sold
        // if (($model->record->item_id)!=($model->id))
        // {
        //   echo $model->name;
        // }

      ?>
    </div>

</div>
