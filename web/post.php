<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "lib/mercadopago.php";

$access_tokens = array(
  "MLA" => "TEST-5065100305679755-012611-36d05dd89010a4e897c93ccacba22886__LA_LC__-201657914",
  "MLB" => "TEST-5575956555775329-032209-45a4c2384bd02f7606375af29c0b0ebd__LC_LD__-209264106",
  "MLM" => "TEST-8125048893657995-012611-971865e2db51654ac76a28b66ff6e174__LC_LD__-201658709",
  "MCO" => "TEST-8926119823541847-022316-89a07f0dbaeb094a9ebeb0741f364cb7__LA_LD__-201658731",
  "MLC" => "TEST-4301459443670481-022409-500160028f3e305c59f42c4e0e918629__LA_LC__-206913132",
  "MLV" => "TEST-5168834635263799-022312-943336e39e1b654ed455ecf1fa01cc26__LA_LD__-201655393"
);

$emails_test = array(
  "MLA" => "test_user_40522467@testuser.com",
  "MLB" => "test_user_75091695@testuser.com",
  "MLM" => "test_user_89751801@testuser.com",
  "MCO" => "test_user_44237579@testuser.com",
  "MLC" => "test_user_87174229@testuser.com",
  "MLV" => "test_user_38279382@testuser.com"
);

if($_REQUEST['paymentMethodId'] == ""){
  $_REQUEST['paymentMethodId'] = $_REQUEST['paymentMethodIdSelector'];
}

$preference = array();

$preference['token'] = $_REQUEST['token'];
$preference['transaction_amount'] = (float) $_REQUEST['amount'];
$preference['installments'] = (int) $_REQUEST['installments'];
$preference['payment_method_id'] = $_REQUEST['paymentMethodId'];
$preference['description'] = "Example.. test";
$preference['payer']['email'] = $emails_test[$_REQUEST['site_id']];

if(isset($_REQUEST['issuer']) && $_REQUEST['issuer'] != "" && $_REQUEST['issuer'] > -1){
  $preference['issuer_id'] = $_REQUEST['issuer'];
}

$mercadopago = new MP($access_tokens[$_REQUEST['site_id']]);
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
