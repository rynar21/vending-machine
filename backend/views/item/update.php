<?php
/*
    By: Melissa Ho
    21/07/2019
*/

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'Update Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="item-update">
    <!-- 页面 标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <!-- 显示 表格 -->
    <?= $this->render('_form_update', ['model' => $model]) ?>

    <hr />

    <!-- 显示还没成功购买的产品 -->
    <div class="row">
        <h3 class="col-sm-12">
            Available Items
        </h3>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'store_id',
            'box.code',
            'name',
            'price',
            ['attribute'=> 'status', 'value' => 'statusText'],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

</div>
