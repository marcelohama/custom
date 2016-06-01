<?php

include "lib/mercadopago.php";
include "lib/test.php";

if(isset($_REQUEST['type']) && isset($_REQUEST['data_id']) && $_REQUEST['type'] == 'payment'){
  $site_id = $_REQUEST['site_id'];
  $payment_id = $_REQUEST['data_id'];

  $mercadopago = new MP(MercadoPagoTest::getAccessTokenSellerTest($site_id));
  $payment = $mercadopago->search_paymentV1($payment_id);


  // print_r($payment);

  if($payment['status'] == 200){

    //flow to create card in customer
    if($payment['response']['status'] == 'approved'){
      $customer_id = $payment['response']['metadata']['customer_id'];
      $token = $payment['response']['metadata']['token'];
      $payment_method_id = $payment['response']['payment_method_id'];
      $issuer_id = (int) $payment['response']['issuer_id'];

      //create card
      $card = $mercadopago->create_card_in_customer($customer_id, $token, $payment_method_id, $issuer_id);

      print_r($card);
    }

  } //end if http status


}

?>
