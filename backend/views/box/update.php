<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Box */

$this->title = 'Update Box: ' . $model->code;
// $this->params['breadcrumbs'][] = ['label' => 'Boxes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>

<div class="box-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
