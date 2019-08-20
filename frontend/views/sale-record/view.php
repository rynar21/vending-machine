<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Payment Success';
?>

<!-- 购买成功页面 -->
<div class="sale-record-view">

        <!-- 标题 -->
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10 headline">
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
        <?= $this->render('/item/details',[
                'model' => $item_model,
            ]) ?>

        <br/>
        <br/>

        <!-- 购买成功信息 -->
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8">
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
        </div>

        <!-- 完成交易 按钮 -->
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
                <a href="<?= Url::to(['store/view','id'=>$item_model->store_id]) ?>" class="btn btn-primary btn-available">
                    Done
                </a>

                <br/>
                <br/>

                <a href="<?= Url::to(['sale-record/invoice','id'=> $model->id]) ?>" class="btn btn-default btn-cancel">
                    Print Receipt
                </a>
            </div>
        </div>

 </div>
