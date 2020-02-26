<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SaleRecord */

$this->title = 'Update Sale Record: ' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Sale Records', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="sale-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
