<?php
/* @var $model common\models\Box */

use yii\helpers\Html;
?>
<div class="thumbnail">
    <?php echo "Box: ".$model->code; ?>
    <hr>
    <?php
        if ($model->item) {
            echo ($model->item->name);
        }

    ?>
    <?php if ($model->status == $model::STATUS_AVAILABLE): ?>
        <div>GOT ITEM</div>
    <?php else: ?>
        <div>NO ITEM</div>
        <?= Html::a('Add Item', ['item/create', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    <?php endif ?>
</div>
