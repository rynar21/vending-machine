<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>


<div class="row">
    <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 item_details_box">
        <div class="row item_details">
            <div class="item_details_image col-sm-5 col-lg-4 col-xs-6">
                <img src="<?php echo $model->imageUrl ?>"/>

            </div>
            <div class="item_details_name col-sm-7 col-lg-8 col-xs-6">
                <?= $model->name ?>
            </div>
        </div>

        <hr />

        <div class="row text-center item_details_price">
            <div class="col-sm-12">
                <?= $model->pricing ?>
            </div>
        </div>
  </div>
</div>
