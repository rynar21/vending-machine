<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Payment Progress';
?>

<div class="sale-record-update">

    <!-- 页面标题 -->
    <div class="row">
        <div class="col-sm-offset-2 col-sm-10 headline">
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
    <?= $this->render('/item/details',[
            'model' => $item_model,
    ]) ?>

    <br/>
    <br/>

    <!-- 购买流程 -->
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8">
            <h4>
                Please follow the following steps to make payment:
                <br/>
                <br/>
                1. Scan QR Code shown at the vending machine.
                <br/>
                2. Select your payment method.
                <br/>
                3. After payment, tab on 'Next' button to proceed.
            </h4>
        </div>
    </div>

    <!-- 检查订单状态按钮 -->
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
            <a href="<?= Url::base() ?>/sale-record/check?id=<?= $item_model->id?>" class="btn btn-primary btn-available" data-toggle="modal">
                Next
            </a>
        </br></br>

        </div>
    </div>

 </div>
