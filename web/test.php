<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$posible_test = array(

  array(
    "title" => "MLA - APPROVED - VISA",
    "credit_card" => "4509 9535 6623 3704",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "Otro",
    "document_number" => "123456789",
    "amount" => 699.99
  ),
  array(
    "title" => "MLA - APPROVED - MASTER",
    "credit_card" => "5031 7557 3453 0604",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "Otro",
    "document_number" => "123456789",
    "amount" => 400
  )
  ,
  array(
    "title" => "MLB - APPROVED - VISA",
    "credit_card" => "4235 6477 2802 5682",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "CPF",
    "document_number" => "19119119100",
    "amount" => 699.99
  )
  ,
  array(
    "title" => "MLB - APPROVED - MASTER",
    "credit_card" => "5031 4332 1540 6351",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "CPF",
    "document_number" => "19119119100",
    "amount" => 400
  ),
  array(
    "title" => "MLM - APPROVED - DEBVISA",
    "credit_card" => "4357 6064 1502 1810",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "Otro",
    "document_number" => "123456789",
    "amount" => 699.99
  ),
  array(
    "title" => "MLM - APPROVED - DEBMASTER",
    "credit_card" => "5031 7531 3431 1717",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "Otro",
    "document_number" => "123456789",
    "amount" => 400
  ),
  array(
    "title" => "MLM - APPROVED - VISA CREDIT",
    "credit_card" => "4941 3371 3002 9283",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "Otro",
    "document_number" => "123456789",
    "amount" => 400
  ),
  array(
    "title" => "MCO - APPROVED - VISA",
    "credit_card" => "4013 5406 8274 6260",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "CC",
    "document_number" => "123456789",
    "amount" => 5699.99
  )
  ,
  array(
    "title" => "MCO - APPROVED - MASTER",
    "credit_card" => "5254 1336 7440 3564",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "CC",
    "document_number" => "123456789",
    "amount" => 7000
  )
  ,
  array(
    "title" => "MLV - APPROVED - VISA",
    "credit_card" => "5177076164300010",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "CI-V",
    "document_number" => "123456",
    "amount" => 5699.99
  )
  ,
  array(
    "title" => "MLV - APPROVED - MASTER",
    "credit_card" => "4966382331109310",
    "month" => "12",
    "year" => "2019",
    "name" => "APRO APRO",
    "security_code" => "123",
    "document_type" => "CI-V",
    "document_number" => "123456",
    "amount" => 7000
  )
  //
  // array(
  //   "credit_card" => "",
  //   "month" => "",
  //   "year" => "",
  //   "name" => "",
  //   "security_code" => "",
  //   "document_type" => "",
  //   "document_number" => ""
  // ),
);

?>

<ul id="countrys">
  <li><a href="?site_id=MLA"> Argentina - MLA</a></li>
  <li><a href="?site_id=MLB"> Brasil - MLB</a></li>
  <li><a href="?site_id=MLC"> Chile - MLC</a></li>
  <li><a href="?site_id=MCO"> Colombia - MCO</a></li>
  <li><a href="?site_id=MLM"> Mexico - MLM</a></li>
  <li><a href="?site_id=MLV"> Venezuela - MLV</a></li>
</ul>


<ul id="instant-suit-test">
  <?php foreach ($posible_test as $cases) {

    $variable_function = "'".$cases['credit_card']."','".$cases['month']."','".$cases['year']."','".$cases['name']."','".$cases['security_code']."','".$cases['document_type']."','".$cases['document_number']."','".$cases['amount']."'";
    ?>

    <li onclick="setValuesOnInput(<?php echo $variable_function; ?>)">
      <p><label class="test_title"><b>Title:</b></label> <?php echo $cases['title']; ?> </p>
      <p><label class="test_credit_card"><b>Credit Card:</b></label> <?php echo $cases['credit_card']; ?> </p>
      <p><label class="test_name"><b>Name:</b></label> <?php echo $cases['name']; ?> </p>

      <div class="test-hidden-inputs">
        <p><label class="test_month"><b>Month:</b></label> <?php echo $cases['month']; ?> </p>
        <p><label class="test_year"><b>Year:</b></label> <?php echo $cases['year']; ?> </p>
        <p><label class="test_security_code"><b>Security Code:</b></label> <?php echo $cases['security_code']; ?> </p>
        <p><label class="test_document_type"><b>Type Document:</b></label> <?php echo $cases['document_type']; ?> </p>
        <p><label class="test_document_number"><b>Document Number:</b></label> <?php echo $cases['document_number']; ?> </p>
        <p><label class="test_amount"><b>Amount:</b></label> <?php echo $cases['amount']; ?> </p>
      </div>
    </li>

  <?php } ?>


</ul>


<style>

#countrys{
  position: fixed;
  top: 0;
  left: 10px;
  width: 160px;
  border: 2px dashed;
  padding: 10px;
}

#countrys li{
  list-style: none;
  border: 1px solid #cecece;
  margin: 5px 0;
  cursor: pointer;
  float: left;
  width: 100%;
  background-color: #fff;
}

#countrys li a{
  text-decoration: none;
  color: #000;
  width: 100%;
  float: left;
  padding: 5px;
  text-transform: uppercase;
}

#instant-suit-test{
  margin: 0;
  padding: 10px;
  position: fixed;
  width: 325px;
  overflow: auto;
  top: 10px;
  right: 10px;
  list-style: none;
  text-transform: uppercase;
  font-size: 9px;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  border: 2px dashed;
  height: 625px;
}

#instant-suit-test li{
  border: 1px solid #cecece;
  float: left;
  margin: 5px 10px;
  padding: 5px;
  cursor: pointer;
  background-color: #fff;
  width: 130px;
  min-height: 105px;
}

#instant-suit-test li p{
  margin: 4px;
}
#instant-suit-test li label{
  float: left;
  width: 100%;
}

.test-hidden-inputs{
  display: none;
}

</style>


<script>

  function setValuesOnInput(credit_card, month, year, name, security_code, document_type, document_number, amount){
    console.log(credit_card);

    document.querySelector("#cardNumber").value = credit_card;
    document.querySelector("#cardExpirationMonth").value = month;
    document.querySelector("#cardExpirationYear").value = year;
    document.querySelector("#cardholderName").value = name;
    document.querySelector("#securityCode").value = security_code;
    document.querySelector("#docType").value = document_type;
    document.querySelector("#docNumber").value = document_number;
    document.querySelector("#amount").value = amount;



    var event_test = {
      type: "keyup"
    }

    guessingPaymentMethod(event_test);

    if(config_mp.create_token_on_event){
      validateInputsCreateToken();
    }
  }



</script>
