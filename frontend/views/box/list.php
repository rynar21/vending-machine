<?php
use common\models\Store;
use common\models\Box;
use common\models\Item;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
// use yii\widgets\LinkPager;


// @models $item_dataProvider = ItemSearch() model
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>
<?php foreach ($item_dataProvider as $item):?>
    <?php if ($item->status == Item::STATUS_AVAILABLE): ?>
        <div class="col-sm-3 col-xs-6 box_row "  >
             <!-- 产品 显示框 -->

            <div class=" box_item "  >

                <a @click="createPayment(<?= $item->id ?>, <?= $item->price ?>)" data-item-id="<?= $item->id ?>">

                <div class="box-code-id text-center b-color">
                    <div class="box-number"><?= $model->prefix . $item->box->code;  ?></div>
                </div>

                <!-- 产品：图片 显示框 -->
                <div class="row item_image" >
                    <img src="<?=  $item->product->imageUrl ?>" class="img-responsive center-block"  />
                </div>

                <!-- 产品：名字 显示框 -->
                <div class="row item_name text-center">
                    <?= $item->name ?>
                </div>

                <!-- 产品：购买的按钮 -->
                <div class="row text-center item-price  " >
                    <span class="item_price font-color" >
                        <?= $item->pricing ?>
                    </span>
                </div>

                <div class="box-buy text-center b-color">
                    BUY
                </div>

                </a>
            </div>

        </div>
    <?php elseif ($item->status == Item::STATUS_LOCKED): ?>
        <div class="col-sm-3 col-xs-6 box_row ">
             <!-- 产品 显示框 -->

            <div class="box_item">
                <div class="box-code-id text-center background-grey">
                    <div class="box-number"><?=$model->prefix . $item->box->code;  ?></div>
                </div>

                <!-- 产品：图片 显示框 -->
                <div class="row item_image" >
                    <img src="<?= $item->product->imageUrl ?>" class="img-responsive center-block"  />
                    <!-- <center><h1>SOLD OUT</h1></center> -->
                </div>

                <!-- 产品：名字 显示框 -->
                <div class="row item_name text-center">
                    <?= $item->name ?>
                </div>

                <!-- 产品：购买的按钮 -->
                <div class="row text-center item-price" >
                    <span class="item_price font-color" >
                        <?= $item->pricing ?>
                    </span>
                </div>

                <div class="box-buy text-center background-grey">
                    Not Available
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
