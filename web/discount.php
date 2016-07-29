<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "lib/mercadopago.php";
include "lib/test.php";

if(!isset($_REQUEST['site_id'])){
  $_REQUEST['site_id'] = "MLA";
}
$transaction_amount = 1499.90;
$payer_email = MercadoPagoTest::getEmailBuyerTest($_REQUEST['site_id']);
$mercadopago = new MP(MercadoPagoTest::getAccessTokenSellerTest($_REQUEST['site_id']));

if (isset($_REQUEST['coupon_id']) && $_REQUEST['coupon_id'] != '') {
    $response = $mercadopago->check_discount_campaigns(
        $transaction_amount,
        $payer_email,
        $_REQUEST['coupon_id']
    );
    header( 'HTTP/1.1 200 OK' );
    header( 'Content-Type: application/json' );
    echo json_encode( $response );
} else {
    $obj = new stdClass();
    $obj->status = 404;
    $obj->response = array(
        'message' => 'a problem has occurred',
        'error' => 'a problem has occurred',
        'status' => 404,
        'cause' => array()
    );
    header( 'HTTP/1.1 200 OK' );
    header( 'Content-Type: application/json' );
    echo json_encode( $obj );
}
exit();

?>

<br/>
<br/>

<pre>
  <?php /*echo json_encode($_REQUEST, JSON_PRETTY_PRINT);*/ ?>
</pre>
<pre>
  <?php /*echo json_encode($payment, JSON_PRETTY_PRINT);*/ ?>
</pre>
