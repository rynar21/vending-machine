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

<div class="item-result">
  <div class="row">
    <div class="col-md-3">
      <div class="image" > image</div>
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




          <button type="button" class="btn btn-primary col-md-1" id="<?=$model->id?>" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> pay</button>
            <?= Html::a('',['item/ok', 'id' => $model->id,])?>




  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">THANK  YOU</h4>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <a href="index" type="button" class="btn btn-primary ">ok</a>
        </div>
      </div>
    </div>
  </div>


        </a>

        <div class="col-md-1"></div>
      </div>
    </div>
  </div>
    <div class="row break">
      <h4>FEATURED</h4>
    </div>

    <div class="row">
      <div class="col-lg-10 col-md-10 hiiil" >
          <div class="jkk">
            <ul>
                <?php foreach ($item_model->getModels() as $abc):?>
                        <li>
                           <a href="payment?id=<?= $abc->id?>" class="thumbnail">
                            <div class="libox">image</div>
                             <br/>
                           <div class="libox-down">
                             <b><?= $abc->name ?></b>
                           </div>
                           </a>
                        </li>
              <?php endforeach ?>
           </ul>
          </div>
      </div>
    </div>

    <!-- <div class="row outer_box">
      <?php //$count = 0; ?>
        <?php /*foreach ($item_model->query->all() as $item): ?>
          <?php if($count>=4) continue;?>
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
        <?php endforeach*/ ?>
    </div> -->
</div>
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
</script>
<style>
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

/*.product{
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
}*/
</style>
