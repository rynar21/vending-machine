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
          <?= Html::a('Cancel',['cancel', 'id' => $item_model->store_id],['class'=>"btn btn-default btn-cancel",
          'data' => [
              'method' => 'post']])?>
          </a>
        </br></br>

        </div>
    </div>
 </div>
