<?
use Yii;
?>

<?php

$salerecord_id = 2;
$price = 289;
$key_old = 'e6c2b38b0604ff3f4005bb49e357ae0f38fff35ae0d1837ea297ebbe8c6d5d34';
?>
<form id='demo' method="post" action="http://localhost/vending-machine/frontend/web/sale-record/iot">
    <input name="salerecord_id" value="<?= $salerecord_id?>" type="hidden" >
    <input name="price" value="<?= $price?>" type="hidden">
    <input name="key_old" value="<?= $key_old?>" type="hidden">
</form>

<script type="text/javascript">
function autoSubmit(){
 document.getElementById("demo").submit();
}
autoSubmit();
</script>
