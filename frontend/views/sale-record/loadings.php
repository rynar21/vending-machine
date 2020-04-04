<?php
//use Yii;
use yii\helpers\Html;
use yii\helpers\Url;


// require_once('log.php');


$this->title = 'Loadings';
//echo $salerecord_id;
?>


<form id="demo"  method="POST" action="<?= Url::to(['payment/create-order'])?>">

    <input name="salerecord_id" value="<?= $salerecord_id?>" type="hidden" >
    <input name="price" value="<?= $price?>" type="hidden" >

</form>
<?php $this->registerJs("
    $('#demo').submit();
") ?>
