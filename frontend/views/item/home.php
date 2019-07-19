<?php
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

?>

<div class="item-home container">
    <!-- 显示店名 -->
    <div class="row">
      <h2 class="col-lg-12 col-sm-12" style="margin-bottom:0px;">
        <?= $store_model->store_name ?>
      </h2>
    </div>
    <hr/>

    <div class="row">
        <?php $form = ActiveForm::begin(['id'=> $id, 'action' => ['home', 'id' => $id], 'method' => 'get',]); ?>
            <div class="col-sm-8 col-xs-8">
                <?= $form->field($item_model, 'name') -> input('name')
                                                      -> textInput(['placeholder' => "Please enter your item name"])
                                                      -> label(false) ?>
            </div>

            <div class="col-sm-4 col-xs-4" style="border:0px solid blue;">
              <?= Html::submitButton('Search', ['class' => 'btn btn-primary form-group search_btn']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="row">
          <div class="col-sm-12" style="color: #6A6A6A; ">
                Select Item to Purchase:
          </div>
    </div>

    <div class="row" style="border: 0px solid blue;">
      <div class="col-lg-12 col-sm-12" style="border: 0px solid red;">
        <!-- 寻找所有的盒子数据 -->
        <?php foreach($box_data->getModels() as $box): ?>
          <!-- 寻找该店里所有的盒子 -->
          <?php if ($id == ($box->store_id) && ($box->box_status != 0)):?>
              <!-- 如果有，查看盒子里的产品 -->
              <?php foreach($item_data->getModels() as $item): ?>
                  <!-- 如果盒子ID等于商品ID -->
                    <?php if(($id == ($box->store_id)) && ($box->box_id == $item->box_id)): ?>
                      <div class="col-lg-4 col-sm-6 col-xs-6 box_row" style="padding: 0 5px;">
                        <div class="box_item">
                          <a  href="iphone?id=<?= $item->id ?>">
                            <div class="item_image">
                                <img src="<?= Url::base()?>/mel-img/pepsi.jpg" class="img-responsive"/>
                            </div>
                            <div class="text-center item_name" style=" ">
                              <?= $item->name ?>
                            </div>
                          </a>
                        </div>
                      </div>
                    <?php endif; ?>
                <?php endforeach; ?>
          <?php endif; ?>
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

.box_item_1{
  width: 23vw;
  margin: 0 auto;
  box-shadow:2px 0px 10px #CDCDB4;
}

.box_item>a{
  text-decoration: none;
}



.box_item{
  width: 100%;
  height: 20vh;
  margin: 0 auto;
  box-shadow:2px 0px 10px #CDCDB4;
  border: 0px solid red;
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
