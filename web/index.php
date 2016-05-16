<?php

$public_keys = array(
  "MLA" => "TEST-3a0f5da2-c8e4-41c0-901e-338f01f58e2c",
  "MLB" => "TEST-30abef69-9f1e-4e9c-8902-62a5c941ba8e",
  "MLM" => "TEST-fda12e26-c017-440d-8bd5-9537b36076bc",
  "MCO" => "TEST-cd1e674d-7ada-4eab-aa0f-97901cd85de6",
  "MLC" => "TEST-1e7e15ea-b95c-4c18-9b71-a2e33c4d974c",
  "MLV" => "TEST-42e8bb0b-4440-416f-9534-8404649136ae"
);

?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/custom_checkout_mercadopago.css">
</head>

<body>

<div id="mp-box-form">

  <form action="post.php" method="post" id="mercadopago-form" name="pay" >

    <div class="mp-box-inputs mp-line mp-paymentMethodsSelector" style="display:none;">
      <label for="paymentMethodIdSelector">Payment Method <em>*</em></label>
      <select id="paymentMethodIdSelector" name="paymentMethodIdSelector" data-checkout="paymentMethodIdSelector">

      </select>
    </div>

    <div class="mp-box-inputs mp-col-100">
      <label for="cardNumber">Credit card number <em>*</em></label>
      <input type="text" id="cardNumber" data-checkout="cardNumber" placeholder="4509 9535 6623 3704" />
    </div>

    <div class="mp-box-inputs mp-line">
      <div class="mp-box-inputs mp-col-45">
        <label for="cardExpirationMonth">Expiration month <em>*</em></label>
        <select id="cardExpirationMonth" data-checkout="cardExpirationMonth">
          <option value="-1"> Month </option>
          <?php for ($x=1; $x<=12; $x++): ?>
            <option value="<?php echo $x; ?>"> <?php echo $x; ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="mp-box-inputs mp-col-10">
        <div id="mp-separete-date">
          /
        </div>
      </div>

      <div class="mp-box-inputs mp-col-45">
        <label for="cardExpirationYear">Expiration year <em>*</em></label>
        <select  id="cardExpirationYear" data-checkout="cardExpirationYear">
          <option value="-1"> Year </option>
          <?php for ($x=date("Y"); $x<= date("Y") + 10; $x++): ?>
            <option value="<?php echo $x; ?>"> <?php echo $x; ?> </option>
          <?php endfor; ?>
        </select>
      </div>
    </div>

    <div class="mp-box-inputs mp-col-100">
      <label for="cardholderName">Card holder name <em>*</em></label>
      <input type="text" id="cardholderName" name="cardholderName" data-checkout="cardholderName" placeholder="APRO" />
    </div>

    <div class="mp-box-inputs mp-line">
      <div class="mp-box-inputs mp-col-45">
        <label for="securityCode">Security code <em>*</em></label>
        <input type="text" id="securityCode" data-checkout="securityCode" placeholder="123" />
      </div>
    </div>

    <div class="mp-box-inputs mp-col-100 mp-doc">
      <div class="mp-box-inputs mp-col-25 mp-docType">
        <label for="docType">Type <em>*</em></label>
        <select id="docType" name="docType" data-checkout="docType"></select>
      </div>

      <div class="mp-box-inputs mp-col-75 mp-docNumber">
        <label for="docNumber">Document number <em>*</em></label>
        <input type="text" id="docNumber" name="docNumber" data-checkout="docNumber" placeholder="12345678" />
      </div>
    </div>


    <div class="mp-box-inputs mp-col-100 mp-issuer">
      <label for="issuer">Issuer <em>*</em></label>
      <select id="issuer" name="issuer" data-checkout="issuer"></select>
    </div>

    <div class="mp-box-inputs mp-col-100">
      <label for="installments">Installments <em>*</em></label>
      <select id="installments" name="installments" data-checkout="installments"></select>
    </div>


    <div class="mp-box-inputs mp-line">
      <div class="mp-box-inputs mp-col-50">
        <!-- <button id="submit">Pay</button> -->
        <input type="submit" value="Pay" id="submit"/>
      </div>
      <div class="mp-box-inputs mp-col-25">
        <div id="mp-box-loading">
        </div>
      </div>
    </div>

    <div class="mp-box-inputs mp-col-100" style="display:none;">
      <label for="installments">Campos de Teste</label>
      <input type="text" name="site_id" id="site_id" />
      <input type="text" name="amount" id="amount" value="249.99"/>
      <input type="text" name="paymentMethodId" id="paymentMethodId"/>
      <input type="text" name="token" id="token"/>
    </div>

  </form>
</div>


  <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
  <script>
    var mercadopago_site_id = '<?php echo $_REQUEST['site_id']; ?>';
    var mercadopago_public_key = '<?php echo $public_keys[$_REQUEST['site_id']]; ?>';
  </script>

  <script src="js/custom_checkout_mercadopago.js?no_cache=<?php echo time(); ?>"></script>




<?php
  include "test.php";
?>


</body>
