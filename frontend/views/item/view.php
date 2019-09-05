<?php

//use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

use yii\db\Query;
use yii\data\BaseDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<div class="item-view">

        <div class="row">
            <div class="col-sm-offset-2 col-sm-10 headline">
                Payment
            </div>
        </div>

        <hr />

        <?= $this->render('/item/details',[
                'model' => $model,
            ]) ?>

       <br/> <br/>

        <div class="row" >
            <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
                <br/>
                <br/>
                <?php //if($model->status === $model::STATUS_AVAILABLE):?>
                    <?= Html::a('Pay',['/sale-record/create', 'id' => $model->id],['class'=>"btn btn-primary btn-available"])?>
                    <br/><br/>
                <?php //else: ?>
                    <a class="btn btn-unavailable" disabled="disabled">
                        Pay
                    </a>
                    <h5 class="text-left" style="margin:0px; color:red;">
                        <?= '*Item is currently being purchased.' ?>
                    </h5>
                    <br/>
                <?php //endif; ?>

                <a href="<?= Url::base()?>/store/view?id=<?= $model->store_id?>"  class="btn btn-default btn-cancel" >
                    Cancel
                </a>
            </div>
        </div>
 </div>

<style>
    .pay_failed a:hover{
        text-decoration: none;
    }
</style>
