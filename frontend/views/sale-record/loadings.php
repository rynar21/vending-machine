<?php
//use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


// require_once('log.php');


$this->title = 'Loadings';
//echo $salerecord_id;
?>


<!-- <form id="demo"  method="POST" action="<?php// Url::to(['payment/create-order'])?>">

    <input name="salerecord_id" value="<?php// $salerecord_id?>" type="hidden" >
    <input name="price" value="<?php// $price?>" type="hidden" >

</form>
<$this->registerJs("
    $('#demo').submit();
") ?> -->

<?php
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
$js = <<< JS
var device_tag = '111111';
var amount = $price; //((Math.random() * 11) + 1).toFixed(2);
// var salerecord_id = $salerecord_id;

// Do not change the function name, this function will be called by Native APP after payment
function getDeviceTag(message) {
    var param = JSON.parse(message);
    console.log(param.deviceTag);
    device_tag = '111111'; //param.deviceTag;
}

function makePayment(){
    fetch('https://api.payandgo.link/payment?device_tag=' + device_tag, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            amount: amount,
            name: "VM H5 Payment ",
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
        console.log(params)
        checkout.postMessage(JSON.stringify(params));
    }).catch(error => {
        console.log(error);
    });
}



// Do not change the function name, this function will be called by Native APP after payment
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
JS;

$this->registerJs($js, \yii\web\View::POS_HEAD);
?>

<?php
$js = <<< JS
document.getElementById('price').innerHTML = amount;
JS;

$this->registerJs($js);
?>
