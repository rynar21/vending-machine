<?php
/*
    By: Melissa Ho
    22/07/2019
*/
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/*
$store_model = common/models/Store
$item_searchModel = backend/models/ItemSearch
$item_dataProvider = $item_searchModel->search();
*/
?>

<div class="item-home container">
    <!-- 显示店名 -->
    <div class="row">
          <h2 class="col-lg-12 col-sm-12" style="margin-bottom:0px;">
              <?= $store_model->name ?>
          </h2>
    </div>
    <hr/>

    <!-- 搜索产品 -->
    <div class="row">
        <?php $form = ActiveForm::begin(['id'=> $id, 'action' => ['home', 'id' => $id], 'method' => 'get',]); ?>
            <div class="col-sm-8 col-xs-8">
                <?= $form->field($item_searchModel, 'name')
                        -> input('name')
                        -> textInput(['placeholder' => "Please enter your item name"])
                        -> label(false) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
              <?= Html::submitButton('Search', ['class' => 'btn btn-primary form-group search_btn']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <hr style="margin-top:0px;"/>

    <!-- 产品内容 -->
    <div class="row">
          <div class="col-sm-12" style="color: #6A6A6A; ">
                Select Item to Purchase:
          </div>
    </div>

    <!-- 展示所有收购的产品 -->
    <div class="row " style="border: 0px solid blue;">
      <div class="col-sm-12" style="border: 0px solid red;">
          <!-- 产品 输入 -->
          <?php foreach($item_dataProvider->query->all() as $items): ?>
                <div class="col-sm-3 col-xs-6 box_row" style="border:0px solid green; padding:5px 7px;">
                     <!-- 产品 显示框 -->
                    <div class="box_item thumbnail text-center">
                        <a href="<?= Url::base()?>/item/iphone?id=<?= $items->id ?>">
                            <!-- 产品：图片 显示框 -->
                            <div class="item_image">
                                <img src="<?= Url::base()?>/mel-img/pepsi.jpg">
                            </div>
                            <!-- 产品：名字 显示框 -->
                            <div class="item_name">
                                <?= $items->name ?>
                            </div>
                        </a>
                    </div>
                </div>
          <?php endforeach; ?>
       </div>
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
  height: 20vh;
  margin: 0 auto;
  box-shadow:2px 0px 10px #CDCDB4;
  border: 0px solid red;
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
