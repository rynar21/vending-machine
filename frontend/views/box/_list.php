<?php
use common\models\Store;
use common\models\Item;
use yii\helpers\Url;
use yii\helpers\Html;

// $model = Store::findOne(1);
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>


<div class="row " style="border: 0px solid blue;">
    <div class="col-sm-12" style="border: 0px solid red;">
          <!-- 产品 输入 -->
          <?php foreach($model->boxes as $box): ?>
              <?php if ($box->status == $box::BOX_STATUS_NOT_AVAILABLE): ?>

                          <?= $this->render('/box/_view', [
                              'model' => $box,
                          ]) ?>
        
                <?php endif ?>
          <?php endforeach; ?>
      </div>
</div>
