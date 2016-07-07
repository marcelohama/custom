<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "lib/mercadopago.php";
include "lib/test.php";

$params_mercadopago = $_REQUEST['mercadopago_custom'];
$payer_email = MercadoPagoTest::getEmailBuyerTest($params_mercadopago['site_id']);

echo json_encode( $params_mercadopago['amount'], JSON_PRETTY_PRINT );
echo json_encode( $payer_email, JSON_PRETTY_PRINT );
echo json_encode( $params_mercadopago['coupon_code'], JSON_PRETTY_PRINT );


//$discount_info = new MP(MercadoPagoTest::check_discount_campaigns();

?>

