<?php
use yii\helpers\Html;
use app\assets\AppAsset;
/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'Update Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="item-update">

    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <?= $this->render('_form', ['model' => $model]) ?>
    <hr class="row"/>

</div>
