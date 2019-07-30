<?php
use yii\helpers\Html;
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>

<div class="col-sm-6 thumbnail text-center" style="border:1px solid red;">
    <?php if ($model->status == $model::BOX_STATUS_NOT_AVAILABLE): ?>
        <a>
            <?php echo ($model->item->name); ?>
            <br/>
            <?= Html::a('Buy', ['item/view', 'id' => $model->item->id], ['class' => 'btn btn-default']) ?>
        </a>
    <?php else: ?>
        <div> Out of Stock </div>
    <?php endif ?>

</div>
