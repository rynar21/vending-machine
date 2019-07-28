<?php
/* @var $model common\models\Box */

use yii\helpers\Html;
//use common\models\Item;
?>


<div class="thumbnail text-center" style="border:1px solid black;">
    <p>
        <?php echo "Box: ".$model->code; ?>
    </p>

    <!-- 判断 产品是否存在 -->
    <?php if ($model->items): ?>
        <?php foreach($model->items as $item):?>
            <!-- 如果有产品，显示产品 -->
            <h4>
                <b><?php echo ($item->name); ?></b>
            </h4>
            <?= Html::a('Modify Item', ['item/update', 'id' => $item->id], ['class' => 'btn btn-primary']) ?>
        <?php endforeach; ?>
    <?php else: ?>
            <!-- 如果有产品，显示产品 -->
            <h4>
                <b>Out of Stock</b>
            </h4>
            <?= Html::a('Add Item', ['item/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php endif;?>

</div>
