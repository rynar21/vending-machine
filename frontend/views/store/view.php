<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\ItemSearch;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = 'Vending Machine';
?>
<div class="store-view">
    <div class="row">
        <h4 class="col-sm-12">
            <?= $model->name ?>
        </h4>
    </div>

    <hr/>

    <div class="row">
        <?php
        $item_searchModel = new ItemSearch();
         echo $this->render('/item/_search', [
            'id' => $id,
            'item_searchModel' => $item_searchModel,
            ]); ?>
    </div>

    <hr/>

    <!-- <div class="row">
          <div class="col-sm-12" style="color: #6A6A6A; ">
                Select Item to Purchase:
          </div>
    </div> -->

    <?=
    $this->render('/box/list', [
            'model' => $model,
            'item_dataProvider' => $item_dataProvider,
            'pages'=>$pages,
            'store_id'=>$id,
        ]);


        ?>


</div>
