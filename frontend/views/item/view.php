<?php

//use yii\helpers\HtmlPurifier;
use yii\helpers\Html;

use yii\db\Query;
use yii\data\BaseDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$time=time();
?>

<div class="item-view">

        <div class="row">
            <div class="col-sm-offset-2 col-sm-10 headline font-color font-size">
                Payment
            </div>
        </div>

        <hr />

        <?= $this->render('/item/details',[
                'model' => $model,

            ])    ?>

       <br/> <br/>

        <div class="row" >
            <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" >
                <br/>
                <br/>
                <?php if($model->status == $model::STATUS_AVAILABLE&&$model->box->status != $model->box::BOX_STATUS_LOCK):?>
                    <?= Html::a('Pay',  ['/sale-record/product_info',  'id' => $model->id,'time'=>$time,'price'=>$model->price],['class'=>"btn btn-primary btn-available b-color"],
                     [
                        'data' => [
                            'method' => 'post',
                            'params' => [
                                'params_key' => 'params_val'
                            ]
                        ]
                    ])?>
                    <br/><br/>

                <?php else: ?>
                    <a class="btn btn-unavailable " disabled="disabled">
                        Pay
                    </a>
                    <h5 class="text-left" style="margin:0px; color:red;">
                        <?= '*Item is currently being purchased.' ?>
                    </h5>
                    <br/>
                <?php endif; ?>

                <a href="<?= Url::base()?>/store/view?id=<?= $model->store_id?>"  class="font-color btn btn-default btn-cancel " >
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
