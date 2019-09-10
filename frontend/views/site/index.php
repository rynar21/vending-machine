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
            <!-- <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h3 class="tab-p font-weight-bold lead text-center" style=" color:rgba(99,99,99,0.7);">
                      In the era of intellectualization, we are more inclined to pursue a convenient, fast and optimized life, and vending machines emerge as the times require.
                    </h3>
                </div>
            </div> -->
        </div>
    <div class="container-fluid">
        <div class="row">
            <div class="container-fluid">
                <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:5px; margin-top:15px; box-shadow:3px 3px 7px #333333;">
                    <div class="row">
                        <div class="text-center">
                            <h2 class=" text-uppercase text-info font-weight-bold"style="font-size:xx-large;">stores</h2>
                        </div>
                    </div>

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
                                                 <p style="font-size:1.3rem;">ZG503型</p>
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
                                                 <p style="font-size:1.3rem;">ZG503型</p>
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
                                                 <p style="font-size:1.3rem;">ZG503型</p>
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
                                                 <p style="font-size:1.3rem;">ZG503型</p>
                                                 <p>设备规格：长1.12mx宽0.9mx高2.4m</p>
                                                 <p>额定电压：220V/50HZ</p>
                                                 <p>额定功率：1kw</p>
                                                 <p>设备重量：500kg</p>
                                                 <p>支付系统：现金、支付宝、微信支付</p>
                                             </div>
                                         </div>
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
                   <!-- <div class="container-fluid">
                       <div class="container-fluid"style="background:rgba(180,180,180,0.5); border-radius:5px; margin-top:15px; box-shadow:3px 3px 7px #333333;">
                           <div class="row">
                               <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
                                  <div class="position1">
                                    <label class="font-type">这是标题</label>
                                  </div>
                                  <div class="position1">
                                    <label class="font-type">这是标题一</label>
                                  </div>
                                  <div class="position1">
                                    <label class="font-type">这是标题一</label>
                                  </div>
                                  <div class="position1">
                                    <label class="font-type">这是标题一</label>
                                  </div>
                                  <div class="position1">
                                    <label class="font-type">ログアウト</label>

                                  </div>
                                 </div>
                                 <div style="height: 70px;width: 100%;">

                                 </div>

                              <div id="wrapper">
                                    <div class="overlay"></div>


                                    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                                        <ul class="nav sidebar-nav">
                                            <li class="sidebar-brand">
                                                <a href="#">
                                                   Bootstrap 3
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-fw fa-home"></i> Home</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-fw fa-folder"></i> Page one</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-fw fa-file-o"></i> Second page</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-fw fa-cog"></i> Third page</a>
                                            </li>
                                            <li class="dropdown">
                                              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-plus"></i> Dropdown <span class="caret"></span></a>
                                              <ul class="dropdown-menu" role="menu">
                                                <li class="dropdown-header">Dropdown heading</li>
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li><a href="#">Separated link</a></li>
                                                <li><a href="#">One more separated link</a></li>
                                              </ul>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-fw fa-bank"></i> Page four</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-fw fa-dropbox"></i> Page 5</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-fw fa-twitter"></i> Last page</a>
                                            </li>
                                        </ul>
                                    </nav>



                                    <div id="page-content-wrapper">
                                      <button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">
                                        <span class="hamb-top"></span>
                                        <span class="hamb-middle"></span>
                                        <span class="hamb-bottom"></span>
                                      </button>

                                      <div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                      </div>>
                                  </div>


                                </div>
                           </div>
                       </div>
                   </div> -->
               </div>
           </div>
         </div>
