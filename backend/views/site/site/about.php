<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
// $this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
/* div {
  text-align: justify;
  text-justify: inter-word;
} */
 .carousel-inner>.item {
     height: 25vh;
 }
 .carousel-inner {
     height: 22vh;
 }

</style>

<div class="container-fluid">

  <div class="container-fuild">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <img src="../../../image/bg7.jpg" class="img-responsive">
            <div class="carousel-caption">
              <h1>About Us</h1>
              <p>"This is line for vision & Mission. You may modify the following file to customize its content"</p>
            </div>
          </div>

          <div class="item">
            <img src="../../../image/bg10.jpg" class="img-responsive">
            <div class="carousel-caption">
              <h3>Dawn</h3>
              <p>It a new day!</p>
            </div>
          </div>

          <div class="item">
            <img src="../../../image/bg1.jpg" class="img-responsive">
            <div class="carousel-caption">
              <h3>Dark</h3>
              <p>Night is always so much fun!</p>
            </div>
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
  </div>
  <br>


  <div class="container-fluid animated fadeInRight">
      <div class="col-sm-6">
        <img src="../../../image/bg5.jpg" class="img-responsive" alt="Responsive image">
      </div>
      <div class="col-sm-6">
        <h2>Company</h2>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi interdum
          libero metus, et vestibulum neque convallis eget. Sed in enim viverra,
          fringilla dolor ac, lobortis erat. Phasellus ac fermentum tortor.
          Nulla facilisi. Vivamus dignissim placerat faucibus.
        </p>

      </div>
    </div>

    <div class="container-fluid animated fadeInRight">
      <div class="col-sm-6">
        <h2>Our Team</h2>
        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi interdum
          libero metus, et vestibulum neque convallis eget. Sed in enim viverra,
          fringilla dolor ac, lobortis erat. Phasellus ac fermentum tortor.
          Nulla facilisi. Vivamus dignissim placerat faucibus.
        </p>
      </div>

      <div class="col-sm-6 text-center">
        <img src="../../../image/bg4.jpg" class="img-responsive" alt="Responsive image">
      </div>
    </div>
    <div class="container-fluid animated fadeInRight">
        <div class="col-sm-6">
          <img src="../../../image/bg5.jpg" class="img-responsive" alt="Responsive image">
        </div>
        <div class="col-sm-6">
          <h2>Our Expertise</h2>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi interdum
            libero metus, et vestibulum neque convallis eget. Sed in enim viverra,
            fringilla dolor ac, lobortis erat. Phasellus ac fermentum tortor.
            Nulla facilisi. Vivamus dignissim placerat faucibus.
          </p>

        </div>
      </div>

      <div class="container-fluid animated fadeInRight">
        <div class="col-sm-6">
          <h2>Our Social Responsibility</h2>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi interdum
            libero metus, et vestibulum neque convallis eget. Sed in enim viverra,
            fringilla dolor ac, lobortis erat. Phasellus ac fermentum tortor.
            Nulla facilisi. Vivamus dignissim placerat faucibus.
          </p>
        </div>

        <div class="col-sm-6 text-center">
          <img src="../../../image/bg4.jpg" class="img-responsive" alt="Responsive image">
        </div>
      </div>


    <div class="container-fluid p-3 mb-2 bg-success text-white animated fadeInUp">
      <div class="title text-center">
        <h1>Location</h1>
      </div>
      <div class="col-sm-4">
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

<!--About title with background image -->
<!-- <div class="site-about jumbotron" style="background-image: url(../../../image/bg7.jpg); background-size: cover； ">
  <h1>About Us</h1>
  <p>"This is line for vision & Mission. You may modify the following file to customize its content"</p>
</div> -->

<!-- Show google map on website FAIL-->
<!-- <style>
#map {
  height: 400px;  /* The height is 400 pixels */
  width: 100%;  /* The width is the width of the web page */
 }
 </style> -->
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
