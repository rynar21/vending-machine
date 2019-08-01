<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = $model->name;
?>
<div class="store-view">

    <h1>
        <?= $model->name ?>
    </h1>
    <?php echo $this->render('/item/_search', [
        'model' => $searchModel,
    ]); ?>

    <hr/>

    <?= $this->render('/box/_list', [
            'model' => $model,
        ]) ?>

</div>

<style>
.box_row{
  margin: 10px 0px;
}

.box_item{
  width: 100%;
  margin: 0 auto;
  box-shadow:2px 0px 10px #CDCDB4;
}

.box_item_1{
  width: 23vw;
  margin: 0 auto;
  box-shadow:2px 0px 10px #CDCDB4;
}

.box_item>a{
    text-decoration: none;
}

.item_image{
  height: 15vh;
  width: auto;
  border: 0px solid black;
}

.item_image>img{
  height: 95%;
  padding-top: 15px;
  margin: 0 auto;
  z-index:-1;
}

.item_name{
    height: 3vh;
    width: auto;
    color: black;
    border: 0px solid black;
}
</style>
