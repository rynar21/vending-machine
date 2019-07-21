<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\grid\GridView;
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

    <hr />
    <div class="row">
        <h3 class="col-sm-12"> Available Items </h3>
    </div>
    <?= GridView::widget([
        'dataProvider' => $model2,
        'columns' => [
            'name',
            ['attribute'=> 'price', 'value' => 'pricing'],
            'box_id',
            'store_id',
            ['attribute'=> 'status', 'value' => 'statusText'],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

</div>
