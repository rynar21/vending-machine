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

<?php //if($model->item):?>
    <div class="col-sm-3 col-xs-6 box_row" style="padding:5px 7px;">
             <!-- 产品 显示框 -->
            <div class="box_item thumbnail text-center">
                <a style="text-decoration:none; font-size:24px; font-weight:bold; color:black;">
                    <!-- 产品：图片 显示框 -->
                    <div class="row item_image">
                        <img src="<?= Yii::getAlias('@imagePath').'/'.$item->image ?>" class="img-responsive center-block"/>
                    </div>

                    <!-- 产品：名字 显示框 -->
                    <div class="row item_name">
                        <h4><?= $item->name ?></h4>
                    </div>

                    <!-- 产品：购买的按钮 -->
                    <div class="row item_buy">
                        <div class="item_price col-sm-offset-4 col-sm-5">
                            <?= $item->pricing ?>
                        </div>
                        <div class="col-sm-3">
                            <?= Html::a('Buy', ['item/view', 'id' => $item->id], ['class' => 'btn btn-success pull-right']) ?>
                        </div>
                    </div>
                </a>
            </div>
    </div>
<?php //endif;?>
