<?php
// use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\SaleRecord;

/* @var $this yii\web\View */
$this->title = 'Pay & Go';
?>
<script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>
<div class="site-index">
    <h3>Pay & Go</h3>
    <br>
    <br>
    <?php if ($model->status == SaleRecord::STATUS_PENDING): ?>
        <h3 class="text-danger">
            Price: RM <span id="price"></span>
        </h3>
    <?php endif ?>

    <?php if ($model->status == SaleRecord::STATUS_SUCCESS): ?>
        <h3 class="text-danger">
        Please Take your Item. Thank you.
        </h3>
    <?php endif ?>

    <?php if ($model->status == SaleRecord::STATUS_FAILED): ?>
        <h3 class="text-danger">
        Sorry. Your payment has failed.
        </h3>
    <?php endif ?>

    <br><br>

    <?php if ($model->status == SaleRecord::STATUS_PENDING): ?>
    <div v-if="">
        <a onclick="makePayment()" class="btn b-color  btn-lg btn-block" style="color:#FFFF;">Checkout</a>

        <div class="row">
            <div class=" col-sm-12 col-lg-12 text-center" style="margin-top:20px; ">
                <?= Html::a('Cancel',['/payment/cancel', 'id' => $model->id],['class' => "btn btn-default btn-cancel font-color",'style' =>'padding: 9px 12px',
                'data' => [
                    'confirm' => 'Are you sure you want to exit this Store?',
                    'method' => 'post']])?>

            </div>
        </div>

    </div>
    <?php endif ?>

    <?php if ($model->status == SaleRecord::STATUS_SUCCESS || $model->status == SaleRecord::STATUS_FAILED): ?>
        <a href="<?= Url::to(['store/view','id'=>$model->store_id]) ?>" class="btn btn-default btn-cancel font-color " style="padding: 9px 12px;">
             Done
        </a>
    <?php endif ?>

</div>

<?php


$js = <<< JS
var device_tag = '';
var amount = $model->sell_price;
var salerecord_id = "$model->order_number";
//((Math.random() * 11) + 1).toFixed(2);

// Do not change the function name, this function will be called by Native APP after payment
function getDeviceTag(message) {
    var param = JSON.parse(message);
    console.log(param.deviceTag);

    device_tag =  param.deviceTag;
}

function makePayment(){
    fetch('https://api.payandgo.link/payment?device_tag=' + device_tag, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            amount: amount,
            name: "VM H5 Payment",
            remark: "Vending Machine Order Payment"
        })
    }).then(response => {
        return response.json();
    }).then(data => {
        console.log(data);
        var params = {
            order_id: data.order_id,
            method: 'showCheckout'
        };
        console.log(params);
        updateSale(data.order_id);
        checkout.postMessage(JSON.stringify(params));
    }).catch(error => {
        console.log(error);
    });


}


//Do not change the function name, this function will be called by Native APP after payment
function updateStatus(message) {
    var param = JSON.parse(message);
    console.log(param.order_id);
    alert(param.order_id);
    fetch('https://api.payandgo.link/payment/view?order_id=' + param.order_id, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    }).then(response => {
        return response.json();
    }).then(data => {
        console.log(data);
        alert(data.data.order.status_label);
    }).catch(error => {
        alert(error);
        console.log(error);
    });
}

function updateSale(order_id) {
    fetch('https://vm-api.payandgo.link/payment/reference?payandgo_order_number=' + order_id + '&vm_order_number=' + salerecord_id , {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    }).then(response => {
        return response.json();
    }).then(data => {
        console.log(data);
    }).catch(error => {
        alert(error);
        console.log(error);
    });
}
JS;

$this->registerJs($js, \yii\web\View::POS_HEAD);
?>

<?php
$js = <<< JS
document.getElementById('price').innerHTML = amount;
JS;

$this->registerJs($js);
?>
