<?
use Yii;
?>

<?php

$salerecord_id = 37;
$price = 3888;
$key_old = '393d1839f900762a76b832d27139a24cde2dcea51c1e1d6da1c26d44837e250f';
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
