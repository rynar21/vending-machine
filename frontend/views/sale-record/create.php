<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $model common\models\Item */

$this->title = 'Payment';
?>

<div class="sale-record-create">

        <?= $this->render('/sale-record/update', [
            'model' => $model,
        ]) ?>

</div>
