<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\data\BaseDataProvider;
use yii\widgets\ActiveForm;
use common\models\Store;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                 <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img class="img-responsive" src="../web/img/home1.jpg" alt="...">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="../web/img/trade_show.jpg" alt="...">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="../web/img/konbini_vending_oven_medium.jpg" alt="...">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="../web/img/banner04.jpeg" alt="...">
                        </div>
                  </div>

                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                     </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h3 class="tab-p font-weight-bold lead text-center" style=" color:rgba(99,99,99,0.7);">
                      In the era of intellectualization, we are more inclined to pursue a convenient, fast and optimized life, and vending machines emerge as the times require.
                    </h3>
                </div>
            </div>
        </div>
            <div class="container-fluid">
                <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:10px; margin-top:15px;">
                    <div class="row">
                        <div class="text-center">
                            <h2 class=" text-uppercase text-info font-weight-bold"style="font-size:xx-large;">stores</h2>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                            // $count = Store::find()->all();
                            // $arr = [];
                            // foreach ($count as $key=>$value) {
                            //     $arr[] = ['store_name' => $value->store_name];
                            // }
                            // print_r($arr);
                        ?>

                        <?php foreach($store_model->getModels() as $store):?>
                            <div class="col-sm-4 col-lg-4"style="position:relative;">
                                <div class="thumbnail font-weight-bold text-center" style="font-size:x-large;">
                                    <?= $store->store_name ?>
                                    <img src="../web/img/baishi.jpg"/ style="with:100px;height:150px;">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <div class="container-fluid">
            <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:10px; margin-top:15px;">
                <div class="row">
                    <div class="text-center">
                        <h2 class=" text-uppercase text-info font-weight-bold"style="font-size:xx-large;">products</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4">
        				<div class="thumbnail text-center" >
        					<img class="img-responsive" src="../web/img/baishi.jpg" alt=""style="with:100px;height:150px;">
        					<h4>cola</h4>
        					<!-- <p class="text-muted">Client 01</p> -->
        				</div>
        			</div>
        			<div class="col-sm-4 col-md-4 col-lg-4">
        				<div class="thumbnail text-center" >
        					<img class="img-responsive" src="../web/img/kele.jpg" alt=""style="with:100px;height:150px;">
        					<h4>cola</h4>
        					<!-- <p class="text-muted">Client 02</p> -->
        				</div>
        			</div>
        			<div class="col-sm-4 col-md-4 col-lg-4">
        				<div class="thumbnail text-center" >
        					<img class="img-responsive" src="../web/img/baishi.jpg" alt=""style="with:100px;height:150px;">
        					<h4>cola</h4>
        					<!-- <p class="text-muted">Client 03</p> -->
        				</div>
        			</div>
        		</div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:10px; margin-top:15px;">
                <div class="row">
                    <div class="text-center">
                        <h2 class=" text-uppercase text-info font-weight-bold"style="font-size:xx-large;">steps</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <img class="img-responsive img-rounded" src="../web/img/fmj.jpg"/ style="border-radius:10px;">
                    </div>
                    <div class="col-sm-6 text-justify">
                        <p>1.Support WeChat, Alipay, Jingdong wallet, banknotes, coins payment and coins change function.</p>
                        <p>2.Supporting a powerful cloud service management platform, you can query every vending machine sales information, operation status, fault alarm anytime and anywhere through the network.</p>
                        <p>3.It can also sell a variety of snacks, drinks and other products, which have a wide range of applications and high economic returns.</p>
                        <p>4.Fuselage Material: All-steel structure, strong and durable.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
