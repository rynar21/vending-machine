<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Payment Success';
?>

<!-- 购买成功页面 -->
<div class="sale-record-view">

        <!-- 标题 -->
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10 headline font-color">
                Payment Successful
            </div>
        </div>

        <hr />

        <!-- 温馨提示 -->
        <div class="row">
            <h4 class="col-sm-offset-2 col-sm-10" style="color:#737363;">
                Please collect your purchased item.
            </h4>
        </div>

        <!-- 产品信息 -->
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 item_details_box">
            <div class="row item_details">
                <div class="item_details_image col-sm-5 col-lg-4 col-xs-6">
                    <img src="<?php echo $item_model->product->imageUrl ?>"/>

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
            <h5>
                Transaction No:
            </h5>
            <h4>
                <?= $model->id ?>
            </h4>

            <h5>
                Ordered Time:
            </h5>
            <h4>
                <?php echo date('Y-m-d H:i:s', $model->created_at); ?>
            </h4>
      </div>

        <br/>
        <br/>



        <!-- 完成交易 按钮 -->
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
                <a href="<?= Url::to(['store/view','id'=>$item_model->store_id]) ?>" class="btn btn-primary btn-available b-color">
                    Done
                </a>

                <br/>
                <br/>

                <a href="<?= Url::to(['sale-record/invoice','id'=> $model->id]) ?>" class="btn btn-default btn-cancel font-color" target="_blank">
                    View Receipt
                </a>
            </div>
        </div>

 </div>
