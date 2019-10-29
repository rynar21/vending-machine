<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Item;
use common\models\SaleRecord;
use yii\web\NotFoundHttpException;


$this->title = 'Payment Progress';
?>
<div class="sale-record-update">

    <!-- 页面标题 -->
    <div class="row">
        <div class="col-sm-offset-2 col-sm-10 headline">
            Sorry
        </div>
    </div>

    <!-- 分隔线 -->
    <div class="row">
        <div class="col-sm-12" >
            <hr/>
        </div>
    </div>

    <!-- 产品信息 -->
    <?= $this->render('/item/details',[
            'model' => $item_model,
    ]) ?>
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 item_details_box">
            <div class="row item_details">
                <div class="item_details_image col-sm-5 col-lg-4 col-xs-6">
                    <img src="<?php echo $model->imageUrl ?>"/>

                </div>
                <div class="item_details_name col-sm-7 col-lg-8 col-xs-6">
                    <?= $model->name ?>
                </div>
            </div>

            <hr />

            <div class="row text-center item_details_price">
                <div class="col-sm-12">
                    <?= $model->pricing ?>
                </div>
            </div>
      </div>
    </div>
    <br/>
    <br/>

    <!-- 购买流程 -->
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8">
            <h4>
                Sorry, this item has been purchased. Please buy other items.
                <br/>
            </h4>
        </div>
    </div>

    <!-- 检查订单状态按钮 -->
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
          <?= Html::a('Cancel',['cancel', 'id' => $model->id],['class'=>"btn btn-default btn-cancel",
          'data' => [
              'method' => 'post']])?>
          </a>
        </br></br>

        </div>
    </div>
 </div>
