<?php
/* @var $model common\models\Box */

use yii\helpers\Html;
?>
<div class="thumbnail text-center" style="border:1px solid black;">
    <p>
        <?php echo "Box: ".$model->code; ?>
    </p>
    <!-- -->
    <?php if ($model->item): ?>
            <p><?php  echo ($model->item->name); ?></p>
            <?= Html::a('Modify Item', ['item/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php else: ?>
            <p> Out of Stock </p>
            <?= Html::a('Add Item', ['item/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php endif;?>
</div>
