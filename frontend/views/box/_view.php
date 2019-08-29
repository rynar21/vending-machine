<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Item;
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>

<?php if($item):?>
        <div class="col-sm-3 col-xs-6 box_row ">
             <!-- 产品 显示框 -->
            <div class="box_item thumbnail  ">
                <a>
                    <!-- 产品：图片 显示框 -->
                    <div class="row item_image">
                        <img src="<?= $item->imageUrl ?>" class="img-responsive center-block"/>
                    </div>

                    <!-- 产品：名字 显示框 -->
                    <div class="row item_name">
                        <?= $item->name ?>
                    </div>

                    <!-- 产品：购买的按钮 -->
                    <div class="row item_buy">
                        <span class="item_price">
                            <?= $item->pricing ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>
<?php endif;?>
