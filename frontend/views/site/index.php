<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
use yii\data\BaseDataProvider;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <style>
/* Custom Styles */
        ul.nav-tabs{
            width: 15vw;
            margin-top: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
        }
        ul.nav-tabs li{
            margin: 0;
            border-top: 1px solid #ddd;
        }
        ul.nav-tabs li:first-child{
            border-top: none;
        }
        ul.nav-tabs li a{
            margin: 0;
            padding: 8px 16px;
            border-radius: 0;
        }
        ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover{
            color: #fff;
            background: #0088cc;
            border: 1px solid #0088cc;
        }
        ul.nav-tabs li:first-child a{
            border-radius: 4px 4px 0 0;
        }
        ul.nav-tabs li:last-child a{
            border-radius: 0 0 4px 4px;
        }
        ul.nav-tabs.affix{
            top: 5vh; /* Set the top position of pinned element */
        }
    </style>
    <script>
        $('#myAffix').affix({
               offset: {
                  top: 100, bottom: function () {
                     return (this.bottom =
                        $('.bs-footer').outerHeight(true))
                     }
                  }
            })
        $(document).ready(function(){
            $("#myNav").affix({
                offset: {
                    top: 125
              }
            });
        });
    </script>
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
                            <img class="img-responsive" src="../web/img/show.jpg" alt="...">
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
                <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:5px; margin-top:15px; box-shadow:3px 3px 7px #333333;">
                    <div class="row">
                        <div class="text-center">
                            <h2 class=" text-uppercase text-info font-weight-bold"style="font-size:xx-large;">products</h2>
                        </div>
                    </div>
                    <div class="row">
<<<<<<< HEAD
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
                                    <?= $store->name ?>
                                    <img src="<?= $store->image ?>" style="width:130px; height:150px;"/>
                                </div>
=======
                        <div class="col-sm-12 col-lg-12">
                          <div id="myCarousel" class="carousel slide" data-ride="carousel">
                              <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                              </ol>
                           <div class="carousel-inner" role="listbox">
                                  <div class="item active">
                                      <div class="col-sm-6">
                                          <img class="img-responsive" src="../web/img/home1.jpg" alt="...">
                                      </div>
                                      <div class="col-sm-1"></div>
                                      <div class="col-sm-5">
                                          <span style="font-size:1.5rem;">全自动鲜榨橙汁贩卖机</span>
                                          <p style="font-size:0.5rem;">ZG503型</p>
                                          <p>设备规格：长1.12mx宽0.9mx高2.4m</p>
                                          <p>额定电压：220V/50HZ</p>
                                          <p>额定功率：1kw</p>
                                          <p>设备重量：500kg</p>
                                          <p>支付系统：现金、支付宝、微信支付</p>
                                      </div>
                                  </div>
                                  <div class="item">
                                      <div class="col-sm-6">
                                          <img class="img-responsive" src="../web/img/show.jpg" alt="...">
                                      </div>
                                      <div class="col-sm-1"></div>
                                      <div class="col-sm-5">
                                          <span style="font-size:1.5rem;">全自动鲜榨橙汁贩卖机</span>
                                          <p style="font-size:0.5rem;">ZG503型</p>
                                          <p>设备规格：长1.12mx宽0.9mx高2.4m</p>
                                          <p>额定电压：220V/50HZ</p>
                                          <p>额定功率：1kw</p>
                                          <p>设备重量：500kg</p>
                                          <p>支付系统：现金、支付宝、微信支付</p>
                                      </div>
                                  </div>
                                  <div class="item">
                                      <div class="col-sm-6">
                                          <img class="img-responsive" src="../web/img/konbini_vending_oven_medium.jpg" alt="...">
                                      </div>
                                      <div class="col-sm-1"></div>
                                      <div class="col-sm-5">
                                          <span style="font-size:1.5rem;">全自动鲜榨橙汁贩卖机</span>
                                          <p style="font-size:0.5rem;">ZG503型</p>
                                          <p>设备规格：长1.12mx宽0.9mx高2.4m</p>
                                          <p>额定电压：220V/50HZ</p>
                                          <p>额定功率：1kw</p>
                                          <p>设备重量：500kg</p>
                                          <p>支付系统：现金、支付宝、微信支付</p>
                                      </div>
                                  </div>
                                  <div class="item">
                                      <div class="col-sm-6">
                                          <img class="img-responsive" src="../web/img/banner04.jpeg" alt="...">
                                      </div>
                                      <div class="col-sm-1"></div>
                                      <div class="col-sm-5">
                                          <span style="font-size:1.5rem;">全自动鲜榨橙汁贩卖机</span>
                                          <p style="font-size:0.5rem;">ZG503型</p>
                                          <p>设备规格：长1.12mx宽0.9mx高2.4m</p>
                                          <p>额定电压：220V/50HZ</p>
                                          <p>额定功率：1kw</p>
                                          <p>设备重量：500kg</p>
                                          <p>支付系统：现金、支付宝、微信支付</p>
                                      </div>
                                  </div>
>>>>>>> pcl-login
                            </div>

                                  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                               </div>
                          </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:5px; margin-top:15px; box-shadow:3px 3px 7px #333333;">
                    <div class="row">
                        <div class="col-xs-3" id="myScrollspy">
                            <ul class="nav nav-tabs nav-stacked" data-spy="affix" data-offset-top="1000">
                                <li class="active"><a href="#section-1">第一部分</a></li>
                                <li><a href="#section-2">第二部分</a></li>
                                <li><a href="#section-3">第三部分</a></li>
                                <li><a href="#section-4">第四部分</a></li>
                            </ul>
                        </div>
<<<<<<< HEAD
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4">
            				<div class="thumbnail text-center" >
            					<img class="img-responsive" src="../web/img/baishi.jpg" alt=""style="width:130px; height:150px;">
            					<h4>cola</h4>
            					<!-- <p class="text-muted">Client 01</p> -->
            				</div>
            			</div>
            			<div class="col-sm-4 col-md-4 col-lg-4">
            				<div class="thumbnail text-center" >
            					<img class="img-responsive" src="../web/img/kele.jpg" alt=""style="width:130px; height:150px;">
            					<h4>cola</h4>
            					<!-- <p class="text-muted">Client 02</p> -->
            				</div>
            			</div>
            			<div class="col-sm-4 col-md-4 col-lg-4">
            				<div class="thumbnail text-center" >
            					<img class="img-responsive" src="../web/img/baishi.jpg" alt=""style="width:130px; height:150px;">
            					<h4>cola</h4>
            					<!-- <p class="text-muted">Client 03</p> -->
            				</div>
            			</div>
            		</div>
                </div>
            </div>
        <div class="container-fluid">
            <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:5px;margin-top:15px; box-shadow:3px 3px 7px #333333;">
                <div class="row">
                    <div class="text-center">
                        <h2 class=" text-uppercase text-info font-weight-bold"style="font-size:xx-large;">steps</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <img class="img-responsive img-rounded" src="../web/img/fmj.jpg"/ style="border-radius:10px; margin-bottom:20px;">
                    </div>
                    <div class="col-sm-6 text-justify">
                        <p>1.It is designed according to international MDB standard and conforms to international DEX standard. It can support all kinds of international general standard peripherals</p>
                        <p>2.Support bank card, network, electronic wallet, paper money, coins and other payment functions as well as coin change.</p>
                        <p>3.Supporting a powerful cloud service management platform, you can query every vending machine sales information, operation status, fault alarm anytime and anywhere through the network.</p>
                        <p>4.It can sell many kinds of snacks and drinks at the same time. The product has a wide range of applications and high economic benefits.</p>
                        <p>5.Microcomputer control system has intelligent data query, statistics, accounting, fault self-diagnosis and other management functions.</p>
                        <p>6.The size of commodity channel can be changed at any time, flexibly adapted to various commodities of different sizes.</p>
                        <p>7.It has power-down protection function and memory function.</p>
                        <p>8.Standard photoelectric delivery detection system.</p>
                        <p>9.Leakage protection function.</p>
                        <p>9.Fuselage Material: All-steel structure explosion-proof, dust-proof, waterproof and durable.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:5px;margin-top:15px; box-shadow:3px 3px 7px #333333;">
                <div class="row">
                    <div class="text-center">
                        <h2 class=" text-uppercase text-info font-weight-bold"style="font-size:xx-large;">join us</h2>
                        <div class="brief">We have a number of after-sales service outlets and technology research and development bases throughout the country to provide professional and timely services to local customers.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4 text-center">
                        <b style="font-size: 2.5em;line-height: 1;color: #ff6c00;">400-635-9995</b>
                        <p style="font-size: 1.33em;">E-mail :tcn@mail.tcnvending.com</p>
                        <?php $form = ActiveForm::begin(['id' => 'form-index']); ?>
                            <?= $form->field($searchModel, 'contact')->textInput(['autofocus' => true]) ?>
                            <div class="form-group">
                                <?= Html::submitButton('join', ['class' => 'btn btn-primary', 'name' => 'join-button']) ?>
=======
                    <div class="col-sm-9">
                        <div class="container-fluid">
                            <div class="row">
                                <div id="section-1">
                                    <div class="col-sm-4">
                                        <img class="img-responsive" src="../web/img/fmj.jpg"/>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-4">
                                        <span style="font-size:1.5rem;">企业简介</span>
                                        <p style="font-size:0.5rem;">Company profile</p>
                                        <p>真果智能科技有限公司是一家拥有专业的研发设计团队，能自主研发生产一款全智能无人值守的自助零售终端，集鲜榨橙汁、自动贩卖于一体，基于“物联网”架构，通过云端集中管理的一家公司</p>
                                    </div>
                                </div>
>>>>>>> pcl-login
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div id="section-2">
                                    <div class="col-sm-4">
                                        <img class="img-responsive" src="../web/img/fmj.jpg"/>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-4">
                                        <span style="font-size:1.5rem;">企业简介</span>
                                        <p style="font-size:0.5rem;">Company profile</p>
                                        <p>真果智能科技有限公司是一家拥有专业的研发设计团队，能自主研发生产一款全智能无人值守的自助零售终端，集鲜榨橙汁、自动贩卖于一体，基于“物联网”架构，通过云端集中管理的一家公司</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div id="section-3">
                                    <img class="img-responsive" src="../web/img/fmj.jpg"/>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1 col-lg-4">
                                        <span style="font-size:1.5rem;">企业简介</span>
                                        <p style="font-size:0.5rem;">Company profile</p>
                                        <p>真果智能科技有限公司是一家拥有专业的研发设计团队，能自主研发生产一款全智能无人值守的自助零售终端，集鲜榨橙汁、自动贩卖于一体，基于“物联网”架构，通过云端集中管理的一家公司</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div id="section-4">
                                    <div class="col-sm-4">
                                        <img class="img-responsive" src="../web/img/fmj.jpg"/>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-4">
                                        <span style="font-size:1.5rem;">企业简介</span>
                                        <p style="font-size:0.5rem;">Company profile</p>
                                        <p>真果智能科技有限公司是一家拥有专业的研发设计团队，能自主研发生产一款全智能无人值守的自助零售终端，集鲜榨橙汁、自动贩卖于一体，基于“物联网”架构，通过云端集中管理的一家公司</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
