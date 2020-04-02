<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SaleRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Progress';
?>

<div class="sale-record-success" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header"> </div> -->
            <div class="modal-body text-center">
                <img src="<?php echo Yii::getAlias('@static/images/logo1.png') ?>" class="img-responsive center-block pay-image"/>
                <h3 class="modal-title  " style="color: green" >
                    <b>Payment Success</b>
                </h3>
                <div class="h-color">
                    <p>
                        Please follow the steps listed to make payment successfully.
                    </p>
                </div>
            </div>

            <div class="modal-footer"  >
                <a href="/store/view?id=<?= $model->store_id ?>">
                    <div class="text-center col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 font-color font-pay" >
                        Next
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
