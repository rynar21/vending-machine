<?php
use common\models\Store;
/* @var $model common\models\Store */

// $model = Store::findOne(1);
?>

<div class="row" style="background: white; border: 1px solid black; padding: 35px;">
  <div class="">
      <?php foreach($model->boxes as $box): ?>
              <div class="col-md-3 button">
                  <?= $this->render('_view', [
                      'model' => $box,
                  ]) ?>
              </div>
      <?php endforeach ?>
    </div>
</div>
