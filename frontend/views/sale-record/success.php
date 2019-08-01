<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SaleRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Progress';
?>

<div class="sale-record-success" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header"> </div> -->

            <div class="modal-body text-center">
                <img src="<?= Url::base()?>/img/logo1.png" class="img-responsive center-block" style="max-height:100%; max-width:100%;" />
                <br/>
                <h3 class="modal-title" >
                    <b>Payment Success</b>
                </h3>
                <p style="color: green;">
                    Please follow the steps listed to make payment successfully.
                </p>
            </div>

            <div class="modal-footer"  style="width:100%; border-top:2px solid black;">
                <a href="view?id=<?= $model->item_id ?>">
                    <div class="text-center col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8" style="font-size:25px; font-weight:bold;">
                        Next
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
