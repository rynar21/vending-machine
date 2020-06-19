<?php
// use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Pay & Go';
?>
<div class="site-index">
    <h3>Pay & Go Demo</h3>
    <br>
    <br>
    <h3 class="text-danger">
        Price: RM <span id="price"></span>
    </h3>
    <br><br>
    <a onclick="makePayment()" class="btn btn-success btn-lg btn-block">Demo Checkout</a>
</div>

<?php
$urlFronted = Yii::getAlias('@urlFrontend/');

$js = <<< JS
var device_tag = '';
var amount = $price;
var salerecord_id = "$salerecord_id";
var urlFrontend = "$urlFronted";
//"http://localhost:20080/";
//((Math.random() * 11) + 1).toFixed(2);

// Do not change the function name, this function will be called by Native APP after payment
function getDeviceTag(message) {
    var param = JSON.parse(message);
    console.log(param.deviceTag);
    device_tag = param.deviceTag;
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
        console.log('123456');
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
    fetch(urlFrontend + 'sale-record/reference?order_number=' + order_id + '&salerecord_id=' + salerecord_id , {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    }).then(response => {
        return response.json();
    }).then(data => {
        console.log(data);
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
