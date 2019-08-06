<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = $model->name;
?>
<div class="store-view">
    <div class="row">
        <h1 class="col-sm-12">
            <?= $model->name ?>
        </h1>
    </div>

    <hr/>

    <div class="row">
        <?php echo $this->render('/item/_search', [
            'id' => $id,
            'item_searchModel' => $item_searchModel,
            ]); ?>
    </div>

    <hr/>

    <div class="row">
          <div class="col-sm-12" style="color: #6A6A6A; ">
                Select Item to Purchase:
          </div>
    </div>

    <?= $this->render('/box/_list', [
            'model' => $model,
            'item_dataProvider' => $item_dataProvider,
        ]) ?>

</div>
