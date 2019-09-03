<?php
/*
    By: Melissa Ho
    21/07/2019
*/

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">
    <!-- 页面标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <!-- 显示 表格 -->
    <?= $this->render('_form_create', [
        'model' => $model,
    ]) ?>

</div>
