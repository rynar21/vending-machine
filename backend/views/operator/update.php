<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operator */

$this->title = 'Update Operator: ' . $model->Operator_ID;
$this->params['breadcrumbs'][] = ['label' => 'Operators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Operator_ID, 'url' => ['view', 'id' => $model->Operator_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="operator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
