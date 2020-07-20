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

    <?php /*
    <div class="row">
        <?php
            $item_searchModel = new ItemSearch();
            echo $this->render('/item/_search', [
                'id' => $id,
                'item_searchModel' => $item_searchModel,
            ]);
        ?>
    </div>
    */ ?>

    <div class="row">
        <?= $this->render('/box/list', [
            'model' => $model,
            'item_dataProvider' => $item_dataProvider,
            'store_id'=>$id,
        ]); ?>
    </div>

</div>

<?php
$js = <<< JS
var device_tag = '1111';

// Do not change the function name, this function will be called by Native APP after payment
function getDeviceTag(message) {
    var param = JSON.parse(message);
    console.log(param.deviceTag);
    device_tag = param.deviceTag;
}

// Do not change the function name, this function will be called by Native APP after payment
function updateStatus(message) {
    var param = JSON.parse(message);

    setTimeout(function() {
        console.log('should wait 1 s');
        store_vue.updateInfo(param.order_id);
    }, 1000);
}
JS;

$this->registerJs($js, \yii\web\View::POS_HEAD);
?>

<?php
$vue_js = <<< JS
store_vue = new Vue({
    el: '#store-vue',
    data: {
        isLoading: false,
    },
    methods: {
        createPayment(item_id, amount)
        {
            // alert("createPayment: " + item_id + ", RM " + amount);
            // return false;

            if (this.isLoading)
            {
                // prevent creating multiple transaction request
                return false;
            }

            this.isLoading = true;

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
                this.createSaleRecord(data.order.order_id, item_id);
            }).catch(error => {
                console.log(error);
            });
        },
        makePayment(order_id)
        {
            var params = {
                order_id: order_id,
                method: 'showCheckout'
            };
            console.log('Native API: ', params)
            checkout.postMessage(JSON.stringify(params));
        },
        createSaleRecord(order_id, item_id) {
            // alert("createSaleRecord: " + order_id + ", item_id: " + item_id);
            //return false;

            // fetch('http://localhost:21088/payment/create', {
            fetch('https://vm-api.payandgo.link/payment/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    reference_no: order_id,
                    item_id: item_id,
                })
            }).then(response => {
                return response.json();
            }).then(data => {
                this.makePayment(order_id);
            }).catch(error => {
                alert('createSaleRecord: ' + error);
                console.log(error);
            }).finally(() => {
                this.isLoading = false;
            });
        },
        updateInfo(order_id)
        {
            fetch('https://api.payandgo.link/payment/view?order_id=' + order_id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                return response.json();
            }).then(data => {
                // do something here
                alert(data.data.order.status_label);
                console.log(data);
            }).catch(error => {
                this.error_message = order_id + '\\n' + error;
                console.log(error);
            }).finally(() => {
                this.isLoading = false;
            });
        }
    },
});
JS;

$this->registerJs($vue_js);
?>
