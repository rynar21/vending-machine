<?php

use yii\helpers\Html;
use yii\helpers\Url;


// require_once('log.php');


$this->title = 'Loading';
 //$time = time();
?>

<div id="loading" class="text-center">
    <br>
    <br>
    <br>
    <p class="text-muted">
        <i class="fa fas fa-spinner fa-3x fa-spin"></i>
    </p>
    <br>
    <p class="text-emphasis">System Loading...</p>
</div>

<form id="demo" action="<?= Yii::getAlias('@urlFrontend/payment/create') ?>">
    <input name="id" value="<?=$id?>" type="hidden">
    <button type="submit" value="Submit">Retry</button>
</form>

<?php $this->registerJs("
    $('#demo').submit();
") ?>
