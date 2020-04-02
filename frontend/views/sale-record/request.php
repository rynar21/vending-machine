<?php
//use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Request';
?>





 <form id="demo" method="POST" action="https://spfintech.sains.com.my/xservice/H5PaymentAction.cashier.do">
     <input type="hidden" id="merchantId" name="merchantId" value="M100001040">
     <input type="hidden" type="text" name="merOrderNo" value="<?= $referenceNo ?>">
     <input type="hidden" id="detailURL" name="detailURL" value="<?= Yii::$app->vm->url.'payment/check?id='. $id;?>">
     <input type="hidden" type="text" name="securityData" value="<?= $token ?>">
</form>

<?php $this->registerJs("
    $('#demo').submit();
") ?>
