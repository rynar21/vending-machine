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



    <div class="row " >
         <div  class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center">

             <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">no</button> -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8" style=" border:0px solid ;">
                           <br/>
                              <img src="<?= Url::base()?>/img/logo1.png" class="img-responsive center-block" style="max-height:100%;max-width:100%;" />

                        <br/>
                            <h style="color:red;"> Please follow the steps listed to make payment successfully.</h>
                       <br/>
                       <br/>
                        <div class=" modal-footer"  style="width:100%; border-top:1px solid black;">

                            <a href="<?= Url::to(['item/cannot','id'=>$model->id]) ?>">
                                <div class="text-center col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8"  class="btn btn-default"
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

                <div class="modal fade in" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8" style=" border:0px solid ;">
                         <br/>
                            <img src="<?= Url::base()?>/img/logo1.png" class="img-responsive center-block" style="max-height:100%;max-width:100%;" />

                      <br/>
                          <h style="color:green;">Eroor.........</h>
                     <br/>
                     <br/>
                      <div class=" modal-footer"  style="width:100%; border-top:1px solid black;">


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
<?php $this->registerJs("
$('#exampleModal').modal('show');
") ?>
