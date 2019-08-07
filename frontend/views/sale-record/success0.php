<?php

$item_id = $_POST['item_id'];
$status = $_POST['payment_status'];
$invoice = $_POST['invoice'];
mysql_query("UPDATE Orders SET status='$status' WHERE order_id='$invoice'");

?>
<form id="vmPay" action="" method="post">
<input id="itemId" name="itemId" value="<?= $item_id ?>">
<input id="hidden" name="" value="">
<input id="hidden" name="item_number" value="<?php echo mktime(); ?>">
<input type="hidden" name="return" value="http://80.202.213.240/apps/tickets/buy/success/" />
<input type="hidden" name="cancel_return" value="http://80.202.213.240/apps/tickets/buy/cancelled/" />
<input type="hidden" name="notify_url" value="http://80.202.213.240/apps/tickets/buy/ipn/" />
<input type="submit" value="Add to Cart" class="ticketShowButton submit" title="Payment via PayPal">
</form>
