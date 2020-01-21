<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Item;
use common\models\SaleRecord;
use yii\web\NotFoundHttpException;


$this->title = 'Loding';
 //$time = time();
?>
<form id="demo" action="http://localhost/vending-machine/frontend/web/sale-record/create">
    <input name="id" value="<?=$id?>" type="hidden" >
    <input name="time" value="<?=$time?>" type="hidden">
</form>

<?php $this->registerJs("
    $('#demo').submit();
") ?>
