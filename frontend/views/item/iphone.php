<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\data\BaseDataProvider;


/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<div class="item-index" style=" border:1px solid red;">

  <div class="body-content">

    <div class="row">
        <div class="col-sm-offset-2 col-sm-10" style=" font-size:35px;">
            <h>payment</h>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style=" border:1px solid red; height:50px;">
            <hr />
        </div>
    </div>

    <div class="row">
        <div class="col-sm-offset-4 col-sm-4 " style=" border:1px solid red; height:240px;">
            <div  class="top"  style=" border:1px solid red; height:140px;">
                <div class=" pull-left " style=" border:1px solid blue; height:140px ;width:30%;">
                    <img src="../web/img/kele.jpg" class="img-responsive center-block"></img>
                </div>
                <div class="  pull-left " style=" border:1px solid blue; height:140px;width:70%;">
                    Pesdah Ssdajs Mysdajsd Csdbashd Osdsb.
                </div>
            </div>
                <hr/>
            <div class="col-sm-12 buttom" style=" border:1px solid green; height:50px;margin-top:5px;">
            </div>
        </div>
    </div>

    <div class="row " >
        <div class="col-sm-offset-4 col-sm-4 text-center" style="margin-top:20px;">
            <button type="button" class="btn btn-primary" style=" width:100%;height:40px;">Pay</button>
              <br/>
               <br/>
            <button type="button" class="btn btn-primary" style=" width:100%;height:40px; background-color:#FFFFFF; color:black;">Cancel</button>
        </div>
    </div>



   </div>
 </div>
