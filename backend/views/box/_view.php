<?php
/* @var $model common\models\Box */

use yii\helpers\Html;
use common\models\Item;
?>
<div class="thumbnail text-center" style="border:1px solid black;">
    <p>
        <?php echo "Box: ".$model->code; ?>
    </p>
    <!-- 判断 产品是否存在 -->
    <?php if ($model->item): ?>
            <!-- 如果有产品，显示产品 -->
            <p><?php  echo ($model->item->name); ?></p>
            <?= Html::a('Modify Item', ['item/update', 'id' => $model->item->id], ['class' => 'btn btn-primary']) ?>

    <?php else: ?>
            <!-- 如果有产品，显示产品 -->
            <p> Out of Stock </p>
            <?= Html::a('Add Item', ['item/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php endif;?>
</div>
