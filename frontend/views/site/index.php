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
        .font-type{
        color: white;
        }
        .position1{
        position: relative;
        float: left;
        width: 20%;
        height: 50px;
        text-align: center;
        line-height: 50px;
        }
        @import "https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css";

        body {
        position: relative;
        overflow-x: hidden;
        }
        body,
        html {
        height: 100%;
        background-color: white;
        }
        .nav .open > a {
        background-color: transparent;
        }
        .nav .open > a:hover {
        background-color: transparent;
        }
        .nav .open > a:focus {
        background-color: transparent;
        }
        /*-------------------------------*/
        /*           Wrappers            */
        /*-------------------------------*/
        #wrapper {
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        -webkit-transition: all 0.5s ease;
        padding-left: 0;
        transition: all 0.5s ease;
        }
        #wrapper.toggled {
        padding-left: 220px;
        }
        #wrapper.toggled #sidebar-wrapper {
        width: 220px;
        }
        #wrapper.toggled #page-content-wrapper {
        margin-right: -220px;
        position: absolute;
        }
        #sidebar-wrapper {
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        -webkit-transition: all 0.5s ease;
        background: #1a1a1a;
        height: 100%;
        left: 220px;
        margin-left: -220px;
        overflow-x: hidden;
        overflow-y: auto;
        transition: all 0.5s ease;
        width: 0;
        z-index: 1000;
        }
        #sidebar-wrapper::-webkit-scrollbar {
        display: none;
        }
        #page-content-wrapper {
        padding-top: 70px;
        width: 100%;
        }
        /*-------------------------------*/
        /*     Sidebar nav styles        */
        /*-------------------------------*/
        .sidebar-nav {
        list-style: none;
        margin: 0;
        padding: 0;
        position: absolute;
        top: 0;
        width: 220px;
        }
        .sidebar-nav li {
        display: inline-block;
        line-height: 20px;
        position: relative;
        width: 100%;
        }
        .sidebar-nav li:before {
        background-color: #1c1c1c;
        content: '';
        height: 100%;
        left: 0;
        position: absolute;
        top: 0;
        -webkit-transition: width 0.2s ease-in;
        transition: width 0.2s ease-in;
        width: 3px;
        z-index: -1;
        }
        .sidebar-nav li:first-child a {
        background-color: #1a1a1a;
        color: #ffffff;
        }
        .sidebar-nav li:nth-child(2):before {
        background-color: #402d5c;
        }
        .sidebar-nav li:nth-child(3):before {
        background-color: #4c366d;
        }
        .sidebar-nav li:nth-child(4):before {
        background-color: #583e7e;
        }
        .sidebar-nav li:nth-child(5):before {
        background-color: #64468f;
        }
        .sidebar-nav li:nth-child(6):before {
        background-color: #704fa0;
        }
        .sidebar-nav li:nth-child(7):before {
        background-color: #7c5aae;
        }
        .sidebar-nav li:nth-child(8):before {
        background-color: #8a6cb6;
        }
        .sidebar-nav li:nth-child(9):before {
        background-color: #987dbf;
        }
        .sidebar-nav li:hover:before {
        -webkit-transition: width 0.2s ease-in;
        transition: width 0.2s ease-in;
        width: 100%;
        }
        .sidebar-nav li a {
        color: #dddddd;
        display: block;
        padding: 10px 15px 10px 30px;
        text-decoration: none;
        }
        .sidebar-nav li.open:hover before {
        -webkit-transition: width 0.2s ease-in;
        transition: width 0.2s ease-in;
        width: 100%;
        }
        .sidebar-nav .dropdown-menu {
        background-color: #222222;
        border-radius: 0;
        border: none;
        box-shadow: none;
        margin: 0;
        padding: 0;
        position: relative;
        width: 100%;
        }
        .sidebar-nav li a:hover,
        .sidebar-nav li a:active,
        .sidebar-nav li a:focus,
        .sidebar-nav li.open a:hover,
        .sidebar-nav li.open a:active,
        .sidebar-nav li.open a:focus {
        background-color: transparent;
        color: #ffffff;
        text-decoration: none;
        }
        .sidebar-nav > .sidebar-brand {
        font-size: 20px;
        height: 65px;
        line-height: 44px;
        }
        /*-------------------------------*/
        /*       Hamburger-Cross         */
        /*-------------------------------*/
        .hamburger {
        background: black;
        border: none;
        display: block;
        height: 32px;
        margin-left: 15px;
        position: fixed;
        top: 70px;
        width: 32px;
        z-index: 999;
        }
        .hamburger:hover {
        outline: none;
        }
        .hamburger:focus {
        outline: none;
        }
        .hamburger:active {
        outline: none;
        }
        .hamburger.is-closed:before {
        -webkit-transform: translate3d(0, 0, 0);
        -webkit-transition: all 0.35s ease-in-out;
        color: #ffffff;
        content: '';
        display: block;
        font-size: 14px;
        line-height: 32px;
        opacity: 0;
        text-align: center;
        width: 100px;
        }
        .hamburger.is-closed:hover before {
        -webkit-transform: translate3d(-100px, 0, 0);
        -webkit-transition: all 0.35s ease-in-out;
        display: block;
        opacity: 1;
        }
        .hamburger.is-closed:hover .hamb-top {
        -webkit-transition: all 0.35s ease-in-out;
        top: 0;
        }
        .hamburger.is-closed:hover .hamb-bottom {
        -webkit-transition: all 0.35s ease-in-out;
        bottom: 0;
        }
        .hamburger.is-closed .hamb-top {
        -webkit-transition: all 0.35s ease-in-out;
        background-color: rgba(255, 255, 255, 0.7);
        top: 5px;
        }
        .hamburger.is-closed .hamb-middle {
        background-color: rgba(255, 255, 255, 0.7);
        margin-top: -2px;
        top: 50%;
        }
        .hamburger.is-closed .hamb-bottom {
        -webkit-transition: all 0.35s ease-in-out;
        background-color: rgba(255, 255, 255, 0.7);
        bottom: 5px;
        }
        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom,
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
        height: 4px;
        left: 0;
        position: absolute;
        width: 100%;
        }
        .hamburger.is-open .hamb-top {
        -webkit-transform: rotate(45deg);
        -webkit-transition: -webkit-transform 0.2s cubic-bezier(0.73, 1, 0.28, 0.08);
        background-color: #ffffff;
        margin-top: -2px;
        top: 50%;
        }
        .hamburger.is-open .hamb-middle {
        background-color: #ffffff;
        display: none;
        }
        .hamburger.is-open .hamb-bottom {
        -webkit-transform: rotate(-45deg);
        -webkit-transition: -webkit-transform 0.2s cubic-bezier(0.73, 1, 0.28, 0.08);
        background-color: #ffffff;
        margin-top: -2px;
        top: 50%;
        }
        .hamburger.is-open:before {
        -webkit-transform: translate3d(0, 0, 0);
        -webkit-transition: all 0.35s ease-in-out;
        color: #ffffff;
        content: '';
        display: block;
        font-size: 14px;
        line-height: 32px;
        opacity: 0;
        text-align: center;
        width: 100px;
        }
        .hamburger.is-open:hover before {
        -webkit-transform: translate3d(-100px, 0, 0);
        -webkit-transition: all 0.35s ease-in-out;
        display: block;
        opacity: 1;
        }
        /*-------------------------------*/
        /*          Dark Overlay         */
        /*-------------------------------*/
        .overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 1;
        }
        /* SOME DEMO STYLES - NOT REQUIRED */
        /*body,
        html {
        background-color: #583e7e;
        }
        body h1,
        body h2,
        body h3,
        body h4 {
        color: rgba(255, 255, 255, 0.9);
        }
        body p,
        body blockquote {
        color: rgba(255, 255, 255, 0.7);
        }
        body a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: underline;
        }
        body a:hover {
        color: #ffffff;
        }*/
   </style>
   <script>
   $(document).ready(function() {
        var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;
        trigger.click(function() {
            hamburger_cross();
        });
        function hamburger_cross() {
            if (isClosed == true) {
                overlay.hide();
                trigger.removeClass('is-open');
                trigger.addClass('is-closed');
                isClosed = false;
            } else {
                overlay.show();
                trigger.removeClass('is-closed');
                trigger.addClass('is-open');
                isClosed = true;
            }
        }
        $('[data-toggle="offcanvas"]').click(function() {
            $('#wrapper').toggleClass('toggled');
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
