<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>


<div class="row">
    <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 item_details_box">
        <div class="row item_details" style="">
            <div class="item_details_image col-sm-5 col-lg-4">
                <img src="<?= $item->imageUrl ?>"  class="img-responsive" />
            </div>
            <div class="item_details_name col-sm-7 col-lg-8">
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

<style>
.item_details_box{
    margin-top: 12px;
    border: 1px solid #FFFFFF;
    box-shadow: 0px 0px 20px #CDCDB4;
    padding: 10px 20px;
}

.item_details{
    padding: 15px;
    border: 0px solid black;
}

.item_details_image{
    border: 0px solid red;
}

.item_details_image > img{
    height: 110px;
    max-width: 100%;
    margin: 0 auto;
}

.item_details_name{
    font-weight: bold;
    white-space: wrap;
    border: 0px solid purple;
}

.item_details_box > .col-sm-12 > hr{
    border:1px #D4D4D4 solid;
    background-color:#D4D4D4;
}

.item_details_price{
    margin: 5px 0px;
    font-size: 25px;
    color: green;
    font-weight: bold;
    border: 0px solid green;
}
</style>
