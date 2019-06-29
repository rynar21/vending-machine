<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>




        <div class="row">
            <div class="col-md-12">
                <p class="pull-right">
                    <a class="btn btn-success" href="/vending-machine/backend/web/store/create">Create Store</a></p>
            </div>
        </div>
        <br class="row">

      <!-- Search -->


    <div class="store-search">

        <form id="w0" action="/vending-machine/backend/web/store/index" method="get">
        <div class="form-group field-storesearch-store_name">
    <label class="control-label" for="storesearch-store_name">Store Name</label>
    <input type="text" id="storesearch-store_name" class="form-control" name="StoreSearch[store_name]">

    <div class="help-block"></div>
    </div>


        <div class="form-group">

            <button type="submit" class="btn btn-primary">Search</button>
             <!-- Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary'])  -->
        </div>

        </form>


    </div>


      <!-- Search -->
    </div>
    <!-- fenge -->
      <hr style=" height: 8px;
          background-image: linear-gradient(90deg,transparent, #5f5d46, transparent);
          border: 0;" class="simple">
    <!-- fenge -->


    <div class="row">

        <div class="hyu">
          <?php foreach ($dataProvider->query->all() as $select): ?>
            <div class="col-lg-3">
              <br/>
              <a href="<?=Url::base()?>/box/home?id=<?=$select->store_id?>">
                 <div class="btn btn-primary text-center"  style=" width:200px;">
                   <?= $select->store_name ?>
                 </div>
              </a>
            </div>
          <?php endforeach; ?>

        </div>

    </div>

</div>
    <style>

    .btn-primary{
      background-color: #4A4A4A;
    }

    .hyu{
    margin-left: 17%;
      width: 90%;
    }
    .col-lg-3{
      display: inline-block;
      float: none;
    }

    .btn-primary{
       background-color: #4A4A4A;
    	-webkit-transform:scale(0.9);
    	-moz-transform:scale(0.9);
    	-o-transform:scale(0.9);
    	-webkit-transition-duration: 0.5s;
    	-moz-transition-duration: 0.5s;
    	-o-transition-duration: 0.5s;

    }

    .btn-primary:hover{
      color:#8B8970;
      background-color: #CDCDB4;
    	-webkit-transform:scale(1.0);
    	-webkit-box-shadow:0px 0px 8px 	#2B2B2B;
    	-moz-transform:scale(1.0);
    	-moz-box-shadow:0px 0px 1  8px 	#2B2B2B;
    	-o-transform:scale(1.0);
    	-o-box-shadow:0px 0px 8px 	#2B2B2B;

      box-shadow:4px 4px 10px #2B2B2B;
      border:0px solid ;
    }

      .col-md-12 a{
         background-color: #4A4A4A;
      	-webkit-transition-duration: 0.5s;
      	-moz-transition-duration: 0.5s;
      	-o-transition-duration: 0.5s;
        background-color: #CDCDB4;
        /* box-shadow:4px 4px 10px #2B2B2B; */
        border:0px solid ;
      }


    </style>
    <style>
    .form-group{
      display: inline-block;
      float: none;
    }
    </style>
