<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\data\BaseDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.image{
  margin: 0 auto;
  background-color:#EEE5DE;
  text-align: center ;
  line-height: 200px;
  height: 200px; width:250px;
}
.break{
    background-color:#DCDCDC;
    height:40px;
    background-image: linear-gradient(90deg,transparent, #CDB7B5, transparent);
    border: 0;
    box-shadow:0px 1px 3px #2B2B2B;
    padding: 5px 0px 2px 10px; margin: 10px 0;
    text-align: center;
}

.product{
    height: 150px;
    width: 19%;
    margin: 30px 40px;
    text-align: center;
}

.product_name{
    margin-top: -10px;
    font-weight: bold;
    text-align:center;
}

.thumbnail{
    border-radius: 0px 0px 0px 0px;
    color:#575757;
    border: solid 0px;
}
a.thumbnail:hover{
  border-color: #7FFFD4;
  color:#8B8970;
  box-shadow:2px 2px 4px #2B2B2B;
  border:0px solid ;
}

.product_image{
  height: 100px;
  width: 80%;
  margin: 0 auto;
  background-color:#EEE5DE;
  margin-top: 10px;
  text-align: center ;
  line-height: 100px;
}

.outer_box{
  background-color:#F7F7F7;
  margin: 25px 5px;
}
</style>

<div class="item-payment">
  <div class="row">
    <div class="col-md-3">
      <div class="image" > image --------- 111212</div>
    </div>
    <div class="col-md-9" style="background-color: #FEE1FD; padding: 34px 30px; width: 860px;">
      <h1><?= $model->name.'<br>' ?></h1>
      <?= 'Location: Box ID'.$model->box_id.'<br>' ?>

      <div class="row">
        <div class="col-md-7"></div>
        <p class="col-md-1" style="margin-top:18px;">
          Price:
        </p>
        <div class="col-md-2" style="font-size: 30px;">
          <b>RM </b> <?= $model->price ?>
        </div>
        <?= Html::a('Pay', ['result'], ['class' => 'btn btn-success col-md-1']) ?>
        <div class="col-md-1"></div>
      </div>
    </div>
  </div>
    <div class="row break">
      <h4>FEATURED</h4>
    </div>

    <div class="row outer_box">
      <?php $count = 0; ?>
        <?php foreach ($item_model->query->limit(4)->all() as $item): ?>
            <div class="col-md-3 product">
                <a href="payment?id=<?=$item->id?>" class="thumbnail">
                  <div class="product_image">image</div>
                  <br/>
                  <div class="product_name">
                    <?= $item->name ?>
                  </div>
                </a>
            </div>
            <?php $count = $count + 1; ?>
        <?php endforeach ?>
    </div>
</div>
