<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "lib/mercadopago.php";
include "lib/test.php";

if($_REQUEST['paymentMethodId'] == ""){
  $_REQUEST['paymentMethodId'] = $_REQUEST['paymentMethodIdSelector'];
}

$preference = array();

$preference['token'] = $_REQUEST['token'];
$preference['transaction_amount'] = (float) $_REQUEST['amount'];
$preference['installments'] = (int) $_REQUEST['installments'];
$preference['payment_method_id'] = $_REQUEST['paymentMethodId'];
$preference['description'] = "Example.. test";
$preference['payer']['email'] = MercadoPagoTest::getEmailBuyerTest($_REQUEST['site_id']);

if(isset($_REQUEST['issuer']) && $_REQUEST['issuer'] != "" && $_REQUEST['issuer'] > -1){
  $preference['issuer_id'] = $_REQUEST['issuer'];
}

$mercadopago = new MP(MercadoPagoTest::getAccessTokenSellerTest($_REQUEST['site_id']));
$payment = $mercadopago->create_payment($preference);

?>

<a href="index.php?site_id=<?php echo $_REQUEST['site_id']; ?>"><?php echo $_REQUEST['site_id']; ?></a>

<br/>
<br/>

<pre>
  <?php echo json_encode($_REQUEST, JSON_PRETTY_PRINT); ?>
</pre>
<pre>
  <?php echo json_encode($payment, JSON_PRETTY_PRINT); ?>
</pre>
