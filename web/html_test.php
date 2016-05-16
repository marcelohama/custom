<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$posible_test = array(
  "MLA" => array(
    array(
      "type_case" => "ok",
      "title" => "APPROVED - VISA",
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
      "type_case" => "ok",
      "title" => "APPROVED - MASTER",
      "credit_card" => "5031 7557 3453 0604",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "123456789",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Erro card Number",
      "credit_card" => "124356789",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error date expiration",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2016",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error card holder name",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2019",
      "name" => "`12321 apro",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error security code",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "1243",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error document number",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "123",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error all inputs",
      "credit_card" => "5255643634",
      "month" => "1",
      "year" => "2016",
      "name" => "`12343",
      "security_code" => "1234",
      "document_type" => "Otro",
      "document_number" => "123",
      "amount" => 400
    )
  ),
  "MLB" => array(
    array(
      "type_case" => "ok",
      "title" => "APPROVED - VISA",
      "credit_card" => "4235 6477 2802 5682",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CPF",
      "document_number" => "19119119100",
      "amount" => 699.99
    ),
    array(
      "type_case" => "ok",
      "title" => "APPROVED - MASTER",
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
      "type_case" => "error",
      "title" => "Erro card Number",
      "credit_card" => "124356789",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CPF",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error date expiration",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2016",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CPF",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error card holder name",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2019",
      "name" => "`12321 apro",
      "security_code" => "123",
      "document_type" => "CPF",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error security code",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "1243",
      "document_type" => "CPF",
      "document_number" => "19119119100",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error document number",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CPF",
      "document_number" => "12345",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error all inputs",
      "credit_card" => "5255643634",
      "month" => "1",
      "year" => "2016",
      "name" => "`12343",
      "security_code" => "1234",
      "document_type" => "CPF",
      "document_number" => "12345",
      "amount" => 400
    )
  ),
  "MLM" => array(
    array(
      "type_case" => "ok",
      "title" => "APPROVED - DEBVISA",
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
      "type_case" => "ok",
      "title" => "APPROVED - DEBMASTER",
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
      "type_case" => "ok",
      "title" => "APPROVED - VISA CREDIT",
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
      "type_case" => "error",
      "title" => "Erro card Number",
      "credit_card" => "124356789",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "123456789",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error date expiration",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2016",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "123456789",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error card holder name",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2019",
      "name" => "`12321 apro",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "123456789",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error security code",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "1243",
      "document_type" => "Otro",
      "document_number" => "123456789",
      "amount" => 400
    ),
    array(
      "type_case" => "error",
      "title" => "Error all inputs",
      "credit_card" => "5255643634",
      "month" => "1",
      "year" => "2016",
      "name" => "`12343",
      "security_code" => "1234",
      "document_type" => "Otro",
      "document_number" => "123456789",
      "amount" => 400
    )
  ),
  "MCO" => array(
    array(
      "type_case" => "ok",
      "title" => "APPROVED - VISA",
      "credit_card" => "4013 5406 8274 6260",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CC",
      "document_number" => "123456789",
      "amount" => 5699.99
    ),
    array(
      "type_case" => "ok",
      "title" => "APPROVED - MASTER",
      "credit_card" => "5254 1336 7440 3564",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CC",
      "document_number" => "123456789",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Erro card Number",
      "credit_card" => "124356789",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error date expiration",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2016",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error card holder name",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2019",
      "name" => "`12321 apro",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error security code",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "1243",
      "document_type" => "Otro",
      "document_number" => "19119119100",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error document number",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "Otro",
      "document_number" => "123",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error all inputs",
      "credit_card" => "5255643634",
      "month" => "1",
      "year" => "2016",
      "name" => "`12343",
      "security_code" => "1234",
      "document_type" => "Otro",
      "document_number" => "123",
      "amount" => 7000
    )
  ),
  "MLV" => array(
    array(
      "type_case" => "ok",
      "title" => "APPROVED - VISA",
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
      "type_case" => "ok",
      "title" => "APPROVED - MASTER",
      "credit_card" => "4966382331109310",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CI-V",
      "document_number" => "123456",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Erro card Number",
      "credit_card" => "124356789",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CI-V",
      "document_number" => "123456",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error date expiration",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2016",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CI-V",
      "document_number" => "123456",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error card holder name",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "1",
      "year" => "2019",
      "name" => "`12321 apro",
      "security_code" => "123",
      "document_type" => "CI-V",
      "document_number" => "123456",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error security code",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "1243",
      "document_type" => "CI-V",
      "document_number" => "123456",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error document number",
      "credit_card" => "5031 4332 1540 6351",
      "month" => "12",
      "year" => "2019",
      "name" => "APRO APRO",
      "security_code" => "123",
      "document_type" => "CI-V",
      "document_number" => "A",
      "amount" => 7000
    ),
    array(
      "type_case" => "error",
      "title" => "Error all inputs",
      "credit_card" => "5255643634",
      "month" => "1",
      "year" => "2016",
      "name" => "`12343",
      "security_code" => "1234",
      "document_type" => "CI-V",
      "document_number" => "A",
      "amount" => 7000
    )
  )
);

?>

<ul id="countrys">
  <li><a href="?site_id=MLA"> Argentina - MLA</a></li>
  <li><a href="?site_id=MLB"> Brasil - MLB</a></li>
  <!-- <li><a href="?site_id=MLC"> Chile - MLC</a></li> -->
  <li><a href="?site_id=MCO"> Colombia - MCO</a></li>
  <li><a href="?site_id=MLM"> Mexico - MLM</a></li>
  <li><a href="?site_id=MLV"> Venezuela - MLV</a></li>
</ul>

<!--
<ul id="instant-suit-test">

  <?php foreach ($posible_test as $site_id => $cases ) {?>

    <li class="separate"><?php echo $site_id; ?></li>

    <?php
    foreach ($cases as $case) {
      $variable_function = "'".$case['credit_card']."','".$case['month']."','".$case['year']."','".$case['name']."','".$case['security_code']."','".$case['document_type']."','".$case['document_number']."','".$case['amount']."'";
    ?>

      <li onclick="setValuesOnInput(<?php echo $variable_function; ?>)" class="<?php echo $case['type_case']?>">
        <p><b><?php echo $site_id; ?></b> - </b></label> <?php echo $case['title']; ?></p>
      </li>

    <?php } ?>

  <?php } ?>


</ul> -->

<ul id="instant-suit-test">

  <?php
    $site_id = $_REQUEST['site_id'];
  ?>

    <li class="separate">Quick Test (<?php echo $site_id; ?>)</li>

    <?php
    foreach ($posible_test[$site_id] as $case) {
      $variable_function = "'".$case['credit_card']."','".$case['month']."','".$case['year']."','".$case['name']."','".$case['security_code']."','".$case['document_type']."','".$case['document_number']."','".$case['amount']."'";
    ?>

      <li onclick="setValuesOnInput(<?php echo $variable_function; ?>)" class="<?php echo $case['type_case']?>">
        <p></b></label> <?php echo $case['title']; ?></p>
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
      background-color: #fff;
    }

    #instant-suit-test li{
      float: left;
      margin: 5px 10px;
      padding: 5px;
      cursor: pointer;
      background-color: #F5F5F5;
      width: 295px;

    }

    #instant-suit-test li.separate{
      cursor: auto;
      background-color: transparent;
      font-weight: bold;
      font-size: 12px;
    }

    #instant-suit-test li.ok{
      border: 1px solid green;
    }

    #instant-suit-test li.error{
      border: 1px solid red;
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
