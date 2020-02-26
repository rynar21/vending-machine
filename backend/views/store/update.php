<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = $model->name;
// $this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-update">

    <h1>Update <?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
