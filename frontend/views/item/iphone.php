<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\data\BaseDataProvider;


/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<div class="item-index">
    <div class="row">
        <div class="col-sm-4 col-lg-4 " >
        </div>
        <div class=" col-sm-4 col-lg-4 text-center container  " >
            <h1 style=" word-break:break-all;">Payment</h1>
        </div>
        <div class=" col-sm-4 col-lg-4 " >
        </div>
    </div>

    <div class="row" style="margin-top:15px;">
        <!-- <div class=" col-xs-3 col-sm-3 col-lg-3 " style="border:1px solid blue;  height:30px;">
        </div> -->
        <div class="col-sm-offset-3 col-sm-6 text-center" >

                <div style="width:300px;height:300px; border:1px solid red;margin:0  auto; line-height:200px;"><h1 >img</h1></div>


        </div>

    <!-- <div class=" col-xs-3 col-sm-3 col-lg-3" style="border:1px solid blue; height:30px;"> -->
    </div>

    <div class="row" style="margin-top:35px;" >
        <div class="col-sm-offset-3 col-sm-6 text-center" style="font-size:30px;"  >
            <b>worter</b>
            <hr style="margin-top:0px;  border: 2px solid; background-color:black;"/ >
        </div>
    </div>
    <div class="row" style="margin-top:15px;" >
        <div class="col-sm-offset-3 col-sm-6 text-center" style="font-size:30px;"  >
            <b style="color:red;">RM 5</b>
            <hr style="margin-top:0px; border: 2px solid; background-color: black;"/ >
        </div>
    </div>
    <div class="row" style="margin-top:30px;" >
        <div class="col-sm-offset-3 col-sm-6 text-center"  >
            <button type="button" class="btn btn-success">Success</button><br/>
            <button type="button" class="btn btn-danger" style="margin-top:10px;">Danger</button>
        </div>
    </div>
 </div>
