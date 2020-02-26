<?php
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\iot\plugins\Encryption;
use yii\iot\plugins\SarawakPay;

// require_once('log.php');


$this->title = 'Lodings';
//echo $salerecord_id;
?>


<form method="POST" action="http://localhost/vending-machine/frontend/web/sale-record/paycheck">
    Barcode: <input type="text" name="barcode">
    <input name="salerecord_id" value="<?= $salerecord_id?>" type="hidden" >
    <input name="price" value="<?= $price?>" type="hidden" >
    <input type="submit" name="submit">
</form>
