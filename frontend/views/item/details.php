<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>


<div class="row">
    <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 item_details">
        <div>
            <div class="pull-left item_details_image">
                <img src="<?= Yii::getAlias('@imagePath').'/'.$item->image ?>" class="img-responsive center-block"/>
            </div>
            <div class="pull-left text-left item_details_name" >
                <br/>
                <p>
                    <?= $model->name ?>
                </p>
            </div>
        </div>

        <div class="col-sm-12 col-lg-12">
            <hr style="border:1px #D4D4D4 solid; background-color:#D4D4D4;"/>
        </div>

        <div class="col-sm-12 col-lg-12 text-center item_details_price">
            RM  <?= number_format($model->price,2) ?>
        </div>
  </div>
</div>
