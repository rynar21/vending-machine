<?php
use common\models\Store;

// $model = Store::findOne(1);
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>

<div class="row" style="border:1px solid black;">
    <?php foreach($model->boxes as $box): ?>
              <div class="col-md-3 button">
                  <?= $this->render('_view', [
                      'model' => $box,
                  ]) ?>
              </div>
    <?php endforeach ?>
</div>
