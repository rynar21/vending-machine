<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Box */

$this->title = 'Create Box';
$this->params['breadcrumbs'][] = ['label' => 'Boxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
