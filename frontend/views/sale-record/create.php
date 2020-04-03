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
        <div class="col-sm-offset-2 col-sm-10 headline font-color font-size">
            Payment
        </div>
    </div>

    <!-- 分隔线 -->
    <div class="row">
        <div class="col-sm-12" >
            <hr/>
        </div>
    </div>

    <!-- 产品信息 -->
    <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 item_details_box">
        <div class="row item_details">
            <div class="item_details_image col-sm-5 col-lg-4 col-xs-6">
                <img src="<?=  $item_model->product->imageUrl ?>"/>

            </div>
            <div class="item_details_name  col-sm-7 col-lg-8 col-xs-6">
                <?= $item_model->name ?>
            </div>
        </div>


        <div class="row text-center item_details_price font-color">
            <div class="col-sm-12">
                <?= $item_model->pricing ?>
            </div>
        </div>
        <hr />
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 p-color w-color">
            <h4>
                <div class="h-color">Please follow the following steps to make payment:</div>
                <br/>
                <br/>
                1. Go to sararawak pay.
                <br/>

            </h4>
        </div>
  </div>
    <br/>
    <br/>


    <!-- 检查订单状态按钮 -->
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
            <?= Html::a('Cancel',['/payment/cancel', 'id' => $model->id],['class'=>"btn btn-default btn-cancel font-color",
            'data' => [
                'confirm' => 'Are you sure you want to exit this Store?',
                'method' => 'post']])?>

        </div>
    </div>

    <script type="text/javascript">
        setTimeout("location.reload();",5000);
    </script>
 </div>
