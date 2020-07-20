<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\models\ItemSearch;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = 'Vending Machine';
?>
<div id="store-vue" class="store-view">

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
            'store_id'=>$id,
        ]);


        ?>



</div>


<?php
$js = <<< JS
var device_tag = '';
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
        alert('makePayment: ' + error);
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
        alert('updateStatus: ' + error);
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
        alert('updateSale: ' + error);
        console.log(error);
    });
}
JS;

$this->registerJs($js, \yii\web\View::POS_HEAD);
?>

<?php
$js = <<< JS
var device_tag = '1111';
var parking_vue;

// Do not change the function name, this function will be called by Native APP after payment
function getDeviceTag(message) {
    var param = JSON.parse(message);
    console.log(param.deviceTag);
    device_tag = param.deviceTag;
}

// Do not change the function name, this function will be called by Native APP after payment
function updateStatus(message) {
    var param = JSON.parse(message);
    parking_vue.clearInfo();
    parking_vue.loadingAnimation();
    setTimeout(function() {
        console.log('should wait 1 s');
        parking_vue.updateInfo(param.order_id);
    }, 1000);
}
JS;

$this->registerJs($js, \yii\web\View::POS_HEAD);
?>

<?php
$vue_js = <<< JS
new Vue({
    el: '#store-vue',
    data: {
        isLoading: false,
    },
    methods: {
        createPayment(item_id, amount)
        {
            alert("createPayment: " + item_id + ", RM " + amount);

            return false;

            fetch('https://api.payandgo.link/payment?device_tag=' + device_tag, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    amount: amount,
                    name: "VM H5 Payment",
                    remark: "Vending Demo",
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                this.parking_info = data;
            }).catch(error => {
                console.log(error);
            });
        },
        makePayment()
        {
            if (this.parking_info == null) {
                console.log('no info');
                return false;
            }

            var params = {
                order_id: this.parking_info.order_id,
                method: 'showCheckout'
            };
            console.log('Native API: ', params)
            checkout.postMessage(JSON.stringify(params));
        },
    },
});
JS;

$this->registerJs($vue_js);
?>
