<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Product;

?>



    <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 item_details_box">
        <div class="row item_details">
            <div class="item_details_image col-sm-5 col-lg-4 col-xs-6">
                <img src="<?php echo $model->imageUrl ?>"/>

            </div>
            <div class="item_details_name  col-sm-7 col-lg-8 col-xs-6">
                <b><?= $model->name?></b>
                <div style=" font-size:14px;color: #6F6F6F; "><?= product::find()->where(['id'=>$model ->product_id])->one()->description ?></div>
            </div>
        </div>

    

        <div class="row text-center item_details_price font-color">
            <div class="col-sm-12">
                <?= $model->pricing ?>
            </div>
        </div>
  </div>
