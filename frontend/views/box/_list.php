<?php
use common\models\Store;
use common\models\Box;
use yii\helpers\Url;
use yii\helpers\Html;

use yii\widgets\LinkPager;


// @models $item_dataProvider = ItemSearch() model
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>


<div class="row">
    <div class="col-sm-12">
        <!-- 产品 输入 -->
        <?php foreach ($item_dataProvider as $item):?>
                <?= $this->render('/box/_view', [
                    'item' => $item,
                ]) ?>
        <?php endforeach; ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
    <?php
        echo LinkPager::widget([
        'pagination' => $pages,
        'maxButtonCount' => 5,//最多显示的几页
        'firstPageLabel'=>'First',//去到第一页
        'prevPageLabel'=>'Prev',//返回上一页
        'nextPageLabel'=>'Next',//下一页
        'lastPageLabel'=>'Last',//去到最后一页
       ]);?>
      </div>
</div>
