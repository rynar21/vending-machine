<?php
use common\models\Store;
use yii\helpers\Url;
use yii\helpers\Html;
// $model = Store::findOne(1);
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>


<div class="row">
    <div class="col-sm-12">
        <?php foreach ($item_dataProvider->query->all() as $item):?>
            <?php //if($model->item):?>
                <div class="col-sm-3 col-xs-6 box_row" style="padding:5px 7px;">
                         <!-- 产品 显示框 -->
                        <div class="box_item thumbnail text-center" style="height: 27vh;">
                            <a >
                                <!-- 产品：图片 显示框 -->
                                <div class="item_image">
                                    <img src="<?= Url::base()?>/mel-img/pepsi.jpg">
                                </div>
                                <!-- 产品：名字 显示框 -->
                                <div class="item_name">
                                    <h4><?= $item->name ?></h4>

                                </div>
                                <?= Html::a('Buy', ['item/view', 'id' => $item->id], ['class' => 'btn btn-success']) ?>
                            </a>
                        </div>
                </div>
            <?php //endif;?>
        <?php endforeach; ?>

        <!-- 产品 输入 -->
        <?php /*foreach($model->boxes as $box): ?>
                <?php if ($box->status == $box::BOX_STATUS_NOT_AVAILABLE): ?>
                        <?= $this->render('/box/_view', [
                                  'model' => $box,
                              ]) ?>
                <?php endif ?>
        <?php endforeach;*/ ?>

      </div>
</div>
