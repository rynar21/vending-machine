<?php
//use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\iot\plugins\Encryption;
use yii\iot\plugins\SarawakPay;

// require_once('log.php');


$this->title = 'Lodings';
//echo $salerecord_id;
?>


<form id="demo"  method="POST" action="http://localhost:20080/payment/create-order">

    <input name="salerecord_id" value="<?= $salerecord_id?>" type="hidden" >
    <input name="price" value="<?= $price?>" type="hidden" >

</form>
<?php $this->registerJs("
    $('#demo').submit();
") ?>
