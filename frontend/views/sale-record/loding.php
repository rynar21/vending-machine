<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\iot\plugins\Encryption;
use yii\iot\plugins\SarawakPay;

// require_once('log.php');


$this->title = 'Loding';
 //$time = time();
?>

<form id="demo" action="http://localhost:20080/sale-record/create">
    <input name="id" value="<?=$id?>" type="hidden" >
    <input name="time" value="<?=$time?>" type="hidden">
</form>

<?php $this->registerJs("
    $('#demo').submit();
") ?>
<?php echo "1";?>
