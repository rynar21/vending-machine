<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\db\Query;
use yii\data\BaseDataProvider;


/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<!-- <div class="col-lg-12" style=" background-color:#CDC5BF; height:50px;  margin-top:0px;" ></div> -->
<div class="item-index">

  <br/>
    <!-- <div class="jumbotron"></div> -->
    <!-- <div class="body-content"></div> -->
    <div class="row">
      <div class="col-lg-12 col-md-12 container-fluid "  >
        <nav class="navbar navbar-default opl" style="
            background-image: linear-gradient(90deg,transparent, #5f5d46, transparent);
            border: 0;" class="simple"/>
        <div class="container-fluid">
          <div class="navbar-header ">

            <div class="sous">

              <?php $form = ActiveForm::begin([ 'action' => ['index'], 'method' => 'get',]);  ?>
                <div class="form-group">
                <?= $form->field($searchModel, 'name')->textInput()->label('')  ?>
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary pull-right sousuo ']) ?>
                </div>
              <?php ActiveForm::end(); ?>

            </div>
          </div>
        </div>
      </nav>
        <!-- <form class="row iky">
          <input type="text" class="col-lg-offset-9 col-lg-3 col-md-offset-3 col-md-3" style="background-color:#F5F5DC; height:40px; margin-left:70%; margin-top:5px;" />
        </form> -->

    </div>
 </div>
  <div class="row">
      <div class="col-lg-11 col-md-11 hil"  ></div>
  </div>
 <div class="row">
    <div class="col-lg-10 col-md-10 hiil" >
    </div>
 </div>
<div class="row">
  <div class="col-lg-10 col-md-10 hiiil" >

      <div class="jkk">

        <ul>

            <?php foreach ($item_model->getModels() as $abc):?>

                    <li>
                       <a href="payment?id=<?= $abc->id ?>" class="thumbnail">
                        <div class="libox">image</div>
                         <br/>
                       <div class="libox-down">
                         <b><?= $abc->name ?></b>
                       </div>
                       </a>
                    </li>
<b/>
          <?php endforeach ?>

       </ul>
      </div>
  </div>
</div>

  <!-- <canvas id="canvas" width="500" height="500" >cccc</canvas> -->
<a>AAAAAA</a>

</div>

<style >
.sousuo{
  background-color: #AAAAAA;
  border: solid 0px;

}
a.thumbnail:hover{
  border-color: #7FFFD4;
  color:#8B8970;
  box-shadow:2px 2px 4px #2B2B2B;
  border:0px solid ;
}
.pull-right{
  margin-top: 20px;
}
.form-group{
  float: left;
}
.sous{

  margin-top: -14px;
  /* width: 30%;*/

}
.jkk b{
font-size:19px;
}
.libox-down{
margin-top: -10px;
}
.jkk li{
    float: left;
    height: 150px;
    width: 19%;
    background-color: #FAEBD7;
    border: 0px  solid ;
    margin-top: 50px;
    margin-bottom:50px;
    margin-left: 40px;
    text-align: center;
    list-style-type:none;
}
.jkk a{border-radius: 0px 0px 0px 0px;
    text-decoration : none;
    color:#575757;
    border: solid 0px;
}
.libox{
  height: 100px;
  width: 80%;
  margin: 0 auto;
  background-color:#EEE5DE;
  margin-top: 10px;
  text-align: center ;
  line-height: 100px;
}
.opl{
  background-color:#CDC5BF;
   height:50px;
  /* margin-top:20px; */
}
 .hil{
  background-color:#E6E6FA;
  height:300px;
  margin-left: 3.45%;
  box-shadow:2px 5px 5px #2B2B2B;
}
.hiil{
 background-color:#DCDCDC;
 height:40px;
 margin-left: 7%;
 margin-top:20px;
 background-image: linear-gradient(90deg,transparent, #CDB7B5, transparent);
 border: 0;
 box-shadow:0px 1px 3px #2B2B2B;
}
.hiiil{
  background-color:#F7F7F7;
  margin-left: 7%;
  margin-top:10px;
}
</style>
