<?php
use common\models\Store;
use common\models\Box;
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
<script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>

        <div class="row">
            <div class="col-sm-12" >
        <?php foreach ($item_dataProvider as $item):?>
            <a href="<?= Url::base()?>/item/view?id=<?= $item->id ?>">
            <div class="col-sm-3 col-xs-6 box_row "  >
                 <!-- 产品 显示框 -->
                <div class=" box_item "  >
                    <div class="box-code-id text-center b-color">
                        <div class="box-number"><?=$model->prefix . Box::find()->where(['id'=>$item->box_id])->one()->code;  ?></div>
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
        <?php endforeach; ?>

        </div>
    </div>
</div>
