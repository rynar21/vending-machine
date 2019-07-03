<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
/* div {
  text-align: justify;
  text-justify: inter-word;
} */
#map {
  height: 400px;  /* The height is 400 pixels */
  width: 100%;  /* The width is the width of the web page */
 }
.animated {
            background-image: url();
            background-repeat: no-repeat;
            background-position: left top;
            padding-top:0px;
            margin-bottom:30px;
            -webkit-animation-duration: 5s;
            animation-duration: 5s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
         }

         @-webkit-keyframes fadeInRight {
            0% {
               opacity: 0;
               -webkit-transform: translateX(20px);
            }
            100% {
               opacity: 1;
               -webkit-transform: translateX(0);
            }
         }

         @keyframes fadeInRight {
            0% {
               opacity: 0;
               transform: translateX(20px);
            }
            100% {
               opacity: 1;
               transform: translateX(0);
            }
         }

         .fadeInRight {
            -webkit-animation-name: fadeInRight;
            animation-name: fadeInRight;
         }

         @-webkit-keyframes fadeInUp {
           from {
             opacity: 0;
             -webkit-transform: translate3d(0, 100%, 0);
             transform: translate3d(0, 100%, 0);
           }

           to {
             opacity: 1;
             -webkit-transform: translate3d(0, 0, 0);
             transform: translate3d(0, 0, 0);
           }
         }

         @keyframes fadeInUp {
           from {
             opacity: 0;
             -webkit-transform: translate3d(0, 100%, 0);
             transform: translate3d(0, 100%, 0);
           }

           to {
             opacity: 1;
             -webkit-transform: translate3d(0, 0, 0);
             transform: translate3d(0, 0, 0);
           }
         }

         .fadeInUp {
           -webkit-animation-name: fadeInUp;
           animation-name: fadeInUp;
         }

</style>

<div class="body">
  <div class="site-about jumbotron animated fadeInRight">
    <h1>About Us</h1>
    <p>"This is line for vision & Mission. You may modify the following file to customize its content"</p>
  </div>

    <div class="container-fluid animated fadeInRight">

      <div class="col-sm-6 text-center">
        <img src="../../../image/bg4.jpg" class="img-responsive" alt="Responsive image">
      </div>

      <div class="col-sm-6">
        <h1>Company</h1>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi interdum
          libero metus, et vestibulum neque convallis eget. Sed in enim viverra,
          fringilla dolor ac, lobortis erat. Phasellus ac fermentum tortor.
          Nulla facilisi. Vivamus dignissim placerat faucibus.
        </p>
        <!-- <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi interdum
          libero metus, et vestibulum neque convallis eget. Sed in enim viverra,
          fringilla dolor ac, lobortis erat. Phasellus ac fermentum tortor.
          Nulla facilisi. Vivamus dignissim placerat faucibus.
        </p> -->
      </div>

    </div>

    <div class="container-fluid animated fadeInRight">

      <div class="col-sm-6">
        <h1>Our Team</h1>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi interdum
          libero metus, et vestibulum neque convallis eget. Sed in enim viverra,
          fringilla dolor ac, lobortis erat. Phasellus ac fermentum tortor.
          Nulla facilisi. Vivamus dignissim placerat faucibus.
        </p>
      </div>

      <div class="col-sm-6 text-center">
        <img src="../../../image/bg3.jpg" class="img-responsive" alt="Responsive image">
      </div>

    </div>


    <div class="container-fluid p-3 mb-2 bg-success text-white  animated fadeInUp">
      <!-- <div class="title text-center">
        <h1>Location</h1>
      </div> -->

      <div class="col-sm-4">
        <!-- <div id="map"></div>
    <script>
    // Initialize and add the map
    function initMap() {
      // The location of Uluru
      var uluru = {lat: -25.344, lng: 131.036};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 4, center: uluru});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: uluru, map: map});
    }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script> -->
        <h3>Simpang Branch</h3>
        <p>Lorem ipsum dolor sit amet,</p>
        <p>tulibero metus,</p>
        <p>Sed in enim viverra, </p>
        <p>convallisSed in enim </p>
        <p>Tel:  1-123-12-1234</p>
        <p>Fax: (60) 82-123456</p>
        <p>Email: wasd@company.com</p>
        <br>
      </div>

      <div class="col-sm-4">
        <h3>Padawan Branch</h3>
          <p>Lorem ipsum dolor sit amet,</p>
          <p>tulibero metus,</p>
          <p>Sed in enim viverra, </p>
          <p>convallisSed in enim </p>
          <p>Tel:  1-123-12-1234</p>
          <p>Fax: (60) 82-123456</p>
          <p>Email: wasd@company.com</p>
          <br>
      </div>

      <div class="col-sm-4">
        <h3>KL Branch</h3>
        <p>Lorem ipsum dolor sit amet,</p>
        <p>tulibero metus,</p>
        <p>Sed in enim viverra, </p>
        <p>convallisSed in enim </p>
        <p>Tel:  1-123-12-1234</p>
        <p>Fax: (60) 82-123456</p>
        <p>Email: wasd@company.com</p>
        <br>
      </div>

    </div>
</div>
