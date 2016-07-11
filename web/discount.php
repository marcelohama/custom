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

/*if (isset($_REQUEST['acao'])) {
    $cart = Context::getContext()->cart;
    $response = array(
        'status' => 200,
        'valor' => $cart->getOrderTotal(true, Cart::BOTH)
    );
} else {*/
if (isset($_REQUEST['coupon_id']) && $_REQUEST['coupon_id'] != '') {
    $coupon_id = $_REQUEST['coupon_id'];
    $site_id = $_REQUEST['site_id'];
    $response = $mercadopago->check_discount_campaigns($transaction_amount, $payer_email, $coupon_id);
} else {
    $response = array(
        'status' => 400,
        'response' => array(
            'error' => 'invalid_id',
            'message' => 'invalid id'
        )
    );
}
header('Content-Type: application/json');
echo json_encode($response);
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
