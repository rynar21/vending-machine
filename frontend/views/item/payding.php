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

<div class="item-payding" style=" border:0px solid red;" >
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
            <div   class=" col-sm-12 col-lg-12">
                <hr style=" border:1px #D4D4D4 solid; background-color:#D4D4D4;"/>
            </div>
            <div class="col-sm-12 col-lg-12 buttom text-center" style=" margin-top:5px; height:46px;">
                <b style="font-size:25px; color:green;">RM <?= number_format($model->price,2) ?></b>
            </div>
      </div>
   </div>

 <br/> <br/>


    <div class="row">
           <div  class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8">
                <h4>Please follow the following steps to make payment:<br/><br/>
                    1. Scan QR Code shown at the vending machine.<br/>
                    2. Select your payment method.<br/>
                    3. After payment, tab on 'Next' button to proceed.
                </h4>
           </div>
    </div>

    <div class="row " >
        <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">

                <?php
                    $str='';
                        if($model2->status == 10){
                             $str="#exampleModal2";
                        }
                        else {
                             $str="#exampleModal";
                            }
                ?>
                    <!-- <button type="button" class="btn btn-primary" style=" width:100%;height:40px;background-color:#1C86EE;border:0px solid;">Pay</button> -->
                        <button type="button" class="btn btn-primary"  style="width:100%;height:40px;background-color:#1C86EE;border:0px solid;"
                            data-toggle="modal" data-target=<?php  echo $str ?> data-whatever="@mdo">
                            Next
                        </button>
                    <br/>
                  <br/>


        </div>
    </div>

    <div class="row " >
         <div  class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center">

             <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">no</button> -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8" style=" border:0px solid ;">
                           <br/>
                              <img src="<?= Url::base()?>/img/logo.png" class="img-responsive center-block" style="max-height:100%;max-width:100%;" />

                        <br/>
                            <h style="color:red;"> Please follow the steps listed to make payment successfully.</h>
                       <br/>
                       <br/>
                        <div class=" modal-footer"  style="width:100%; border-top:1px solid black;">

                            <a>
                                <div class="text-center col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8"  class="btn btn-default" data-dismiss="modal"
                                style="font-size:25px;font-weight:bold;">
                                  Return
                              </div>
                          </a>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row " >
         <div  class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center">

             <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo">ok</button> -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8" style=" border:0px solid ;">
                         <br/>
                            <img src="<?= Url::base()?>/img/logo.png" class="img-responsive center-block" style="max-height:100%;max-width:100%;" />

                      <br/>
                          <h style="color:green;">Thank you for using our service. Please proceed to end this session.</h>
                     <br/>
                     <br/>
                      <div class=" modal-footer"  style="width:100%; border-top:1px solid black;">

                          <a href="record?id=<?= $model->id ?>">
                              <div class="text-center col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8" style="font-size:25px;font-weight:bold;">
                                Next
                            </div>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
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
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
</script>
