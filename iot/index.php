<form method="POST" action="index.php">
    Barcode: <input type="text" name="barcode">
    <input type="submit" name="submit">
</form>

<?php
require_once('plugins/Encryption.php');
require_once('plugins/SarawakPay.php');
require_once('log.php');

if (isset($_POST['submit']))
{
    $barcode = $_POST['barcode'];

    //Barcode Integration POST data Parameter for Order Creation
    $data = [
        // 'merchantId' => 'M100001040', // To be replace by integration merchant ID
         'merchantId' => 'M100001040',
        // 'qrCode' => $barcode,
        // 'curType' => 'RM',
        // 'notifyURL' => 'https://google.com/',
        'merOrderNo' => '21',
        // 'goodsName' => '',
        // 'detailURL' => '',
        // 'orderAmt' => '0.10',
        // 'remark' => '',
        // 'transactionType' => '1',
        //'sign' => '',
        //'orderNo' => 'ZF202001211000041297',
        // 'tranFlowNo' => 'ZF202001151000041152',
        // 'date' => '20200117155937',
        // 'productNo' => '08',
        // 'orderNo' => 'ZF202001171000041241',
    ];

    $data      = json_encode($data, 320);
    $string    = SarawakPay::post('https://spfintech.sains.com.my/xservice/BarCodePaymentAction.queryOrder.do', $data);
    //SarawakPay::post('https://spfintech.sains.com.my/xservice/BarCodePaymentAction.createOrder.do', $data);
    $array     = json_decode($string);
    print_r('<pre>');
    print_r($array);
    $orderStatus = $array->{'orderStatus'};
    $orderAmt      = $array->{'orderAmt'};
    echo $orderStatus."\n".$orderAmt;


    //$post_inquiry = SarawakPay::post('https://spfintech.sains.com.my/xservice/BarCodePaymentAction.queryOrder.do', $data);
    // $post_refund = SarawakPay::post('https://spfintech.sains.com.my/xservice/BarCodePaymentAction.orderRefund.do', $data);
    // $post_refund_inqury = SarawakPay::post('https://spfintech.sains.com.my/xservice/BarCodePaymentAction.refundOrderQuery.do', $data);
    // $post_cancel = SarawakPay::post('https://spfintech.sains.com.my/xservice/BarCodePaymentAction.closeOrder.do', $data);
    // $reconciliation = SarawakPay::post('https://spfintech.sains.com.my/xservice/BarCodePaymentAction.closeOrder.do', $data);
    // echo $post_data;
    // Log::createLog($post_data);
}

?>
