<?php
use yii\helpers\Html;
use yii\helpers\Url;
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>

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
                <h4><?= $model->item->name ?></h4>
            </div>
            <?= Html::a('Buy', ['item/view', 'id' => $model->item->id], ['class' => 'btn btn-success']) ?>
        </a>
    </div>
</div>

<style>
.search_btn{
  width: 22vw;
}

.box_row{
  margin: 10px 0px;
}

.box_item{
  width: 100%;
  margin: 0 auto;
  box-shadow:2px 0px 10px #CDCDB4;
}

.box_item_1{
  width: 23vw;
  margin: 0 auto;
  box-shadow:2px 0px 10px #CDCDB4;
}

.box_item>a{
    text-decoration: none;
}

.item_image{
  height: 15vh;
  width: auto;
  border: 0px solid black;
}

.item_image>img{
  height: 95%;
  padding-top: 15px;
  margin: 0 auto;
  z-index:-1;
}

.item_name{
    height: 3vh;
    width: auto;
    color: black;
    border: 0px solid black;
}
</style>
