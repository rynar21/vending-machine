<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Finance */

$this->title = 'Create Finance';
// $this->params['breadcrumbs'][] = ['label' => 'Finances', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
