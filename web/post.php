<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "lib/mercadopago.php";
include "lib/test.php";

$params_mercadopago = $_REQUEST['mercadopago_custom'];

if($params_mercadopago['paymentMethodId'] == ""){
  $params_mercadopago['paymentMethodId'] = $params_mercadopago['paymentMethodIdSelector'];
}

$preference = array();

$preference['token'] = $params_mercadopago['token'];
$preference['transaction_amount'] = (float) $params_mercadopago['amount'];
$preference['installments'] = (int) $params_mercadopago['installments'];
$preference['payment_method_id'] = $params_mercadopago['paymentMethodId'];
$preference['description'] = "Example.. test";
$preference['payer']['email'] = MercadoPagoTest::getEmailBuyerTest($params_mercadopago['site_id']);

if(isset($params_mercadopago['issuer']) && $params_mercadopago['issuer'] != "" && $params_mercadopago['issuer'] > -1){
  $preference['issuer_id'] = $params_mercadopago['issuer'];
}

$mercadopago = new MP(MercadoPagoTest::getAccessTokenSellerTest($params_mercadopago['site_id']));
$payment = $mercadopago->create_payment($preference);

?>

<a href="index.php?site_id=<?php echo $params_mercadopago['site_id']; ?>"><?php echo $params_mercadopago['site_id']; ?></a>

<br/>
<br/>

<pre>
  <?php echo json_encode($_REQUEST, JSON_PRETTY_PRINT); ?>
</pre>
<pre>
  <?php echo json_encode($payment, JSON_PRETTY_PRINT); ?>
</pre>
