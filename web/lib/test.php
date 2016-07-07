<?php


class MercadoPagoTest {

  static function getPublicKeyTest($site_id){
    $public_keys = array(
      "MLA" => "TEST-688247aa-6fbc-4d8d-8d6c-d58a077f2a8a",
      "MLB" => "TEST-c7058257-126f-4b3f-aaee-f6217ac0377f",
      "MLM" => "TEST-78e4533c-4b10-45f4-900f-e4c7195c9f74",
      "MCO" => "TEST-e92d52e4-804c-4390-9ec8-e0cfac38919e",
      "MLC" => "TEST-a547c43e-d03f-4e02-9cfd-705b7890ebe0",
      "MLV" => "TEST-ab2ff380-656c-42d8-8b08-4c13629c25ee",
      "MPE" => "TEST-bef28df6-2c17-4855-b762-81afc98f1693"
    );

    return $public_keys[$site_id];
  }

  static function getAccessTokenSellerTest($site_id){
    $access_tokens = array(
      "MLA" => "TEST-5249833162698191-020413-831f3b52f3922cb013847f9e02829d69__LC_LD__-204620652",
      "MLB" => "TEST-2367506043397408-051212-70f86162c12c25c5d44e186b9351a07a__LB_LA__-210968992",
      "MLM" => "TEST-2039333317737006-022418-4d6c34cdf796deca2c8d063c88b3994d__LD_LA__-204638312",
      "MCO" => "TEST-1250090532419011-030814-b92c934d7664f865867f741f0a02117a__LA_LD__-204634828",
      "MLC" => "TEST-1812366329262902-030813-09adc281362b0caf821fc184a2a9cc36__LC_LB__-204638499",
      "MLV" => "TEST-6091109766046547-021209-091cd1352c93079d85e6ae9310ec2945__LB_LC__-204636658",
      "MPE" => "TEST-615948908823631-060918-5f10fe100d903ba929887b796ebaef39__LD_LC__-216731142"
    );
    return $access_tokens[$site_id];
  }

  static function getEmailBuyerTest($site_id){
    $emails_test = array(
      "MLA" => "test_user_26738664@testuser.com",
      "MLB" => "test_user_42014680@testuser.com",
      "MLM" => "test_user_54673885@testuser.com",
      "MCO" => "test_user_72291478@testuser.com",
      "MLC" => "test_user_95201263@testuser.com",
      "MLV" => "test_user_6407898@testuser.com",
      "MPE" => "test_user_3401908@testuser.com"
    );

    return $emails_test[$site_id];
  }

}
