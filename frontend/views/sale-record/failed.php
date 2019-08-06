<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SaleRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Progress';
?>

<div class="sale-record-failed" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header"> </div> -->

            <div class="modal-body text-center">
                <img src="<?= Url::base()?>/img/logo1.png" class="img-responsive center-block" style="max-height:100%; max-width:100%;" />
                <br/>
                <h3 class="modal-title" >
                    <b>Payment Failed</b>
                </h3>
                <div style="color:red;">
                    Please contact the (Vending Machine Company) for more details.
                    <br/>
                    Customer Hotline: 1300-88-2525
                </div>
            </div>

            <div class="modal-footer"  style="width:100%; border-top:2px solid black;">
                <a href="<?= Url::base()?>/store/view?id=<?= $model->store_id ?>">
                    <div class="text-center col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8" style="font-size:25px;font-weight:bold;">
                        Home
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
