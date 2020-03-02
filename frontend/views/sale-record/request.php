<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\iot\plugins\Encryption;
use yii\iot\plugins\SarawakPay;

// require_once('log.php');


$this->title = 'Request';
//echo $salerecord_id;


?>





 <form id="demo" method="POST" action="https://spfintech.sains.com.my/xservice/H5PaymentAction.cashier.do">
     <input type="hidden" id="merchantId" name="merchantId" value="M100001040">
     <input type="hidden" type="text" name="merOrderNo" value="<?= $referenceNo ?>">
     <input type="hidden" id="detailURL" name="detailURL" value="<?= "http://localhost/vending-machine/frontend/web/sale-record/check?id=$id "?>">
     <input type="hidden" type="text" name="securityData" value="<?= $token ?>">
</form>

<?php $this->registerJs("
    $('#demo').submit();
") ?> 
