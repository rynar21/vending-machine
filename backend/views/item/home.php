<?php
use yii\helpers\Html;
use app\assets\AppAsset;
/* @var $this yii\web\View */
/* @var $model common\models\Item */
?>

<div class="item-home">
    <h1 class="row">Modify Item</h1>
    <br/>
    <?= $this->render('_form', ['model' => $item_model]) ?>
    <hr class="row"/>
    <h3 class="row"> Available Item(s): </h3>
    <div class="row" style="border: 2px solid black; padding: 30px;">
      <?php foreach($item_data->query->all() as $item):?>
        <?php foreach($record_data->query->all() as $record):?>
          <?php if($item->id !== $record->item_id):?>
            <div class="col-md-3">
              <div class="text-center"
                style="background: red; color: white; font-size: 25px;
                font-weight: bold; border: 2px solid black; padding: 15px 25px; width: 140px;">
                <?= $item->name?>
                <div style="font-size: 10px; font-style:italic;">
                  <?= 'Box ID '.$item->box_id.'<br>'?>
                  <?php foreach($box_data->query->all() as $box)
                  {
                    if($item->box_id === $box->box_id)
                    {
                      foreach($store_data->getModels() as $store)
                      {
                        if($box->store_id == $store->store_id)
                        {
                          echo $store->store_name;
                        }
                      }
                    }
                  }?>
                </div>
              </div>
            </div>
          <?php endif ?>
          <?php endforeach ?>
      <?php endforeach ?>
    </div>
</div>
