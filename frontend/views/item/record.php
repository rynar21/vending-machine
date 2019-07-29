<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\data\BaseDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<!-- 购买成功页面 -->
<div class="item-record" style=" border:0px solid red;" >
    <!-- 内容 开始 -->
    <div class="body-content">
        <!-- 标题 -->
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10" style=" font-size:35px;">
                <h>
                    Payment Successful
                </h>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" >
                <hr />
            </div>
        </div>

        <!-- 温馨提示 -->
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10" style="color:#737363;"  >
                <h4 >
                    Please collect your purchased item.
                </h4>
            </div>
        </div>

        <!-- 产品信息 -->
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 zz"  >
                <div class="top"  >
                    <div class="pull-left" style=" height:110px ;width:30%; border:0px solid red;margin-top:15px;margin-left:-2%;">
                        <img src="<?= Url::base()?>/kele.jpg" class="img-responsive center-block" style="max-height:100%;max-width:100%;" />
                    </div>
                    <div class="pull-left text-left" style=" border:0px solid blue; height:140px;width:70%; ">
                        <br/>
                        <p>
                            <?= $item_model->name ?>
                        </p>
                     </div>
                </div>

                <div  class=" col-sm-12 col-lg-12">
                    <hr style=" border:1px #D4D4D4 solid; background-color:#D4D4D4;"/>
                </div>

                <div class="col-sm-12 col-lg-12 buttom text-center" style=" margin-top:5px; height:46px;">
                    <b style="font-size:25px; color:green;">
                        RM <?= number_format($item_model->price, 2)?>
                    </b>
                </div>
            </div>
        </div>

        <br/>
        <br/>

        <!-- 购买成功信息 -->
        <div class="row">
            <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 " style="border:0px solid red;">
                <h5>
                    Transaction No:
                </h5>
                <h4>
                    <?= $record_model->id ?>
                </h4>

                <h5>
                    Order Time:
                </h5>
                <h4>
                    <?php echo date('Y-m-d H:i:s', $record_model->created_at); ?>
                </h4>
             </div>
        </div>

    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
            <a href="<?= Url::to(['item/home','id'=>$item_model->store_id]) ?>" >
                <button type="button" class="btn btn-primary"  style="width:100%;height:40px;background-color:#1C86EE;border:0px solid;">
                    Done
                </button>
            </a>

            <br/>
            <br/>

            <a href="#">
                <button type="button" class="btn btn-primary"  style=" width:100%;height:40px; background-color:#FFFFFF; color:black;">
                    Print Receipt
                </button>
            </a>
        </div>
    </div>

   </div>
   <!-- 结束内容 -->
 </div>


<style>
    .zz{
        border: 1px solid #FFFFFF;
        box-shadow:0px 0px 20px #CDCDB4;
        /* box-shadow: -10px 0px 10px #FFFFFF,   /*左边阴影*/
        0px 0px 20px #CDCDB4,  /*上边阴影*/
        -10px 0px 10px green,  /*右边阴影*/
        0px 0px 20px #CDCDB4;" /*下边阴影*/ */
    }
</style>
