<?php
use common\models\Store;
use common\models\Box;
use yii\helpers\Url;
use yii\helpers\Html;

// @models $item_dataProvider = ItemSearch() model
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>


<div class="row">
    <div class="col-sm-12">
        <?php foreach ($item_dataProvider->query->all() as $item):?>
                <?= $this->render('/box/_view', [
                    'item' => $item,
                ]) ?>
        <?php endforeach; ?>

        <!-- 产品 输入 -->
        <?php /*foreach($model->boxes as $box): ?>
                <?php if ($box->status == $box::BOX_STATUS_NOT_AVAILABLE): ?>
                        <?= $this->render('/box/_view', [
                                  'model' => $box,
                              ]) ?>
                <?php endif ?>
        <?php endforeach;*/ ?>

      </div>
</div>
