<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\data\BaseDataProvider;
use yii\helpers\Url;
use common\models\SaleRecord;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<div class="item-payding" style=" border:0px solid red;" >

    <div class="body-content">

        <div class="row">
            <div class="col-sm-offset-2 col-sm-10" style=" font-size:35px;">
                <h>Payment</h>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" >
                <hr/>
            </div>
        </div>

        <div class="row">
              <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 zz"  >
                    <div  class="top"  >
                        <div class=" pull-left " style=" height:110px ;width:30%; border:0px solid red;margin-top:15px;margin-left:-2%;">
                            <img src="<?= Url::base()?>/kele.jpg" class="img-responsive center-block" style="max-height:100%; max-width:100%;" /></div>
                                <div class=" pull-left text-left " style=" border:0px solid blue; height:140px;width:70%; ">
                            <br/>
                         <p><?= $model->name ?></p>
                      </div>
                    </div>
                         <div   class=" col-sm-12 col-lg-12">
                             <hr style=" border:1px #D4D4D4 solid; background-color:#D4D4D4;"/>
                            </div>
                         <div class="col-sm-12 col-lg-12 buttom text-center" style=" margin-top:5px; height:46px;">
                        <b style="font-size:25px; color:green;">RM  <?= number_format($model->price, 2) ?></b>
                    </div>
                 </div>
            </div>
            <br/>
            <br/>

            <div class="row">
               <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8">
                    <h4>Please follow the following steps to make payment:<br/><br/>
                        1. Scan QR Code shown at the vending machine.<br/>
                        2. Select your payment method.<br/>
                        3. After payment, tab on 'Next' button to proceed.
                    </h4>
               </div>
           </div>

               <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".<?= $str ?>">
                   Next
               </button>

       </div>
 </div>

<style>
    .zz{
        border: 1px solid #FFFFFF;
        box-shadow:0px 0px 20px #CDCDB4;
        /*
        box-shadow: -10px 0px 10px #FFFFFF,   // 左边阴影
        0px 0px 20px #CDCDB4,  // 上边阴影
        -10px 0px 10px green,  // 右边阴影
        0px 0px 20px #CDCDB4;" // 下边阴影
         */
    }

    .modal-dialog {
    position: relative;
    width: auto;
    margin: 250px 50px 250px 50px;
    /* margin-top: 10px;
    margin-right: 10px;
    margin-bottom: 10px;
    margin-left: 10px; */
    }
</style>
