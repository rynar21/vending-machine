<?php

use yii\helpers\Html;
use yii\helpers\Url;


// require_once('log.php');


$this->title = 'Loading';
 //$time = time();
?>

<form id="demo" action="<?=  Url::to(['payment/create'])?>">
    <input name="id" value="<?=$id?>" type="hidden" >
    <input name="time" value="<?=$time?>" type="hidden">
</form>

<?php $this->registerJs("
    $('#demo').submit();
") ?>
