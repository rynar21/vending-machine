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

// $this->title = 'Update Item';

?>

<div class="item-update">
    <!-- 页面 标题 -->
    

    <!-- 显示 表格 -->
    <?= $this->render('_form_update', ['model' => $model]) ?>

    <hr />


</div>
