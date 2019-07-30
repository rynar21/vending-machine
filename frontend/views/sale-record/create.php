<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SaleRecord */

$this->title = 'Create Sale Record';
$this->params['breadcrumbs'][] = ['label' => 'Sale Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
