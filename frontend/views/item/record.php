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

<div class="item-record" style=" border:0px solid red;" >
  <div class="body-content">

    <div class="row">
        <div class="col-sm-offset-2 col-sm-10" style=" font-size:35px;">
            <h>Payment</h>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" >
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-sm-offset-2 col-sm-10" style="color:#737363;"  >
            <h4 >Please collect your purchased item.</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 zz"  >
            <div  class="top"  >
                <div class=" pull-left " style=" height:110px ;width:30%; border:0px solid red;margin-top:15px;margin-left:-2%;">
                    <!-- <img src="/img/kele.jpg" class="img-responsive center-block"  height="140px" width="30%"/> -->
                    <img src="<?= Url::base()?>/kele.jpg" class="img-responsive center-block" style="max-height:100%;max-width:100%;" />
                </div>
                <div class=" pull-left text-left " style=" border:0px solid blue; height:140px;width:70%; ">
                    <br/>
                    <p><?= $model->name ?></p>
                </div>
            </div>

            <div  class=" col-sm-12 col-lg-12">
                <hr style=" border:1px #D4D4D4 solid; background-color:#D4D4D4;"/>
            </div>

            <div class="col-sm-12 col-lg-12 buttom text-center" style=" margin-top:5px; height:46px;">
                <b style="font-size:25px; color:green;">RM <?= $model->price ?>.00</b>
            </div>

      </div>
   </div>

 <br/> <br/>

    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 " style="border:0px solid red;">
            <h5>Transaction No:</h5>
            <h4><?=$model2->id ?></h4>
            <h5>Order Time:</h5>
            <h4>
            <?php date_default_timezone_set('PRC'); ?>
            <?php  echo date('Y-m-d h:i:s', time());?>
            </h4>
        </div>
    </div>
    <div class="row " >
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
            <!-- <button type="button" class="btn btn-primary" style=" width:100%;height:40px;background-color:#1C86EE;border:0px solid;">Pay</button> -->

            <a href="#">
                <button type="button" class="btn btn-primary"  style="width:100%;height:40px;background-color:#1C86EE;border:0px solid;">
                  Done
                </button>
            </a>
              <br/>
              <br/>
            <a href="index">
                <button type="button" class="btn btn-primary"  style=" width:100%;height:40px; background-color:#FFFFFF; color:black;">
                    Print Receipt
                </button>
            </a>

        </div>
    </div>



   </div>
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
