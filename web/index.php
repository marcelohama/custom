<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "lib/test.php";

 ?>

<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/custom_checkout_mercadopago.css">
</head>

<body>

<div id="mp-box-form">

  <!-- Copy from here -->

  <?php


    $form_labels = array(
      "form" => array(
        "payment_method" => "Payment Method",
        "credit_card_number" => "Credit card number",
        "expiration_month" => "Expiration month",
        "expiration_year" => "Expiration year",
        "year" => "Year",
        "month" => "Month",
        "card_holder_name" => "Card holder name",
        "security_code" => "Security code",
        "document_type" => "Document Type",
        "document_number" => "Document number",
        "issuer" => "Issuer",
        "installments" => "Installments"
      ),
      "error" => array(
        //card number
        "205" => "Parameter cardNumber can not be null/empty",
        "E301" => "Invalid Card Number",
        //expiration date
        "208" => "Invalid Expiration Date",
        "209" => "Invalid Expiration Date",
        "325" => "Invalid Expiration Date",
        "326" => "Invalid Expiration Date",
        //card holder name
        "221" => "Parameter cardholderName can not be null/empty",
        "316" => "Invalid Card Holder Name",
        //security code
        "224" => "Parameter securityCode can not be null/empty",
        "E302" => "Invalid Security Code",
        //doc type
        "212" => "Parameter docType can not be null/empty",
        "322" => "Invalid Document Type",
        //doc number
        "214" => "Parameter docNumber can not be null/empty",
        "324" => "Invalid Document Number",
        //doc sub type
        "213" => "The parameter cardholder.document.subtype can not be null or empty",
        "323" => "Invalid Document Sub Type",
        //issuer
        "220" => "Parameter cardIssuerId can not be null/empty"
      )
    );
  ?>

  <form action="post.php" method="post" id="mercadopago-form" name="pay" >

    <div class="mp-box-inputs mp-line mp-paymentMethodsSelector" style="display:none;">
      <label for="paymentMethodIdSelector"><?php echo $form_labels['form']['payment_method']; ?> <em>*</em></label>
      <select id="paymentMethodIdSelector" name="paymentMethodIdSelector" data-checkout="paymentMethodIdSelector">
      </select>
    </div>

    <div class="mp-box-inputs mp-col-100">
      <label for="cardNumber"><?php echo $form_labels['form']['credit_card_number']; ?> <em>*</em></label>
      <input type="text" id="cardNumber" data-checkout="cardNumber" placeholder="4509 9535 6623 3704" />
      <span class="mp-error" id="mp-error-205" data-main="#cardNumber"> <?php echo $form_labels['error']['205']; ?> </span>
      <span class="mp-error" id="mp-error-E301" data-main="#cardNumber"> <?php echo $form_labels['error']['E301']; ?> </span>
    </div>

    <div class="mp-box-inputs mp-line">
      <div class="mp-box-inputs mp-col-45">
        <label for="cardExpirationMonth"><?php echo $form_labels['form']['expiration_month']; ?> <em>*</em></label>
        <select id="cardExpirationMonth" data-checkout="cardExpirationMonth">
          <option value="-1"> <?php echo $form_labels['form']['month']; ?> </option>
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
        <label for="cardExpirationYear"><?php echo $form_labels['form']['expiration_year']; ?> <em>*</em></label>
        <select  id="cardExpirationYear" data-checkout="cardExpirationYear">
          <option value="-1"> <?php echo $form_labels['form']['year']; ?> </option>
          <?php for ($x=date("Y"); $x<= date("Y") + 10; $x++): ?>
            <option value="<?php echo $x; ?>"> <?php echo $x; ?> </option>
          <?php endfor; ?>
        </select>
      </div>

      <span class="mp-error" id="mp-error-208" data-main="#cardExpirationMonth"> <?php echo $form_labels['error']['208']; ?> </span>
      <span class="mp-error" id="mp-error-209" data-main="#cardExpirationYear"> </span>
      <span class="mp-error" id="mp-error-325" data-main="#cardExpirationMonth"> <?php echo $form_labels['error']['325']; ?> </span>
      <span class="mp-error" id="mp-error-326" data-main="#cardExpirationYear"> </span>

    </div>

    <div class="mp-box-inputs mp-col-100">
      <label for="cardholderName"><?php echo $form_labels['form']['card_holder_name']; ?> <em>*</em></label>
      <input type="text" id="cardholderName" name="cardholderName" data-checkout="cardholderName" placeholder="APRO" />

      <span class="mp-error" id="mp-error-221" data-main="#cardholderName"> <?php echo $form_labels['error']['221']; ?> </span>
      <span class="mp-error" id="mp-error-316" data-main="#cardholderName"> <?php echo $form_labels['error']['316']; ?> </span>
    </div>

    <div class="mp-box-inputs mp-line">
      <div class="mp-box-inputs mp-col-45">
        <label for="securityCode"><?php echo $form_labels['form']['security_code']; ?> <em>*</em></label>
        <input type="text" id="securityCode" data-checkout="securityCode" placeholder="123" />

        <span class="mp-error" id="mp-error-224" data-main="#securityCode"> <?php echo $form_labels['error']['224']; ?> </span>
        <span class="mp-error" id="mp-error-E302" data-main="#securityCode"> <?php echo $form_labels['error']['E302']; ?> </span>
      </div>
    </div>

    <div class="mp-box-inputs mp-col-100 mp-doc">
      <div class="mp-box-inputs mp-col-35 mp-docType">
        <label for="docType"><?php echo $form_labels['form']['document_type']; ?> <em>*</em></label>
        <select id="docType" name="docType" data-checkout="docType"></select>

        <span class="mp-error" id="mp-error-212" data-main="#docType"> <?php echo $form_labels['error']['212']; ?> </span>
        <span class="mp-error" id="mp-error-322" data-main="#docType"> <?php echo $form_labels['error']['322']; ?> </span>
      </div>

      <div class="mp-box-inputs mp-col-65 mp-docNumber">
        <label for="docNumber"><?php echo $form_labels['form']['document_number']; ?> <em>*</em></label>
        <input type="text" id="docNumber" name="docNumber" data-checkout="docNumber" placeholder="12345678" />

        <span class="mp-error" id="mp-error-214" data-main="#docNumber"> <?php echo $form_labels['error']['214']; ?> </span>
        <span class="mp-error" id="mp-error-324" data-main="#docNumber"> <?php echo $form_labels['error']['324']; ?> </span>
      </div>
    </div>

    <div class="mp-box-inputs mp-col-100 mp-issuer">
      <label for="issuer"><?php echo $form_labels['form']['issuer']; ?> <em>*</em></label>
      <select id="issuer" name="issuer" data-checkout="issuer"></select>

      <span class="mp-error" id="mp-error-220" data-main="#issuer"> <?php echo $form_labels['error']['220']; ?> </span>
    </div>

    <div class="mp-box-inputs mp-col-100">
      <label for="installments"><?php echo $form_labels['form']['installments']; ?> <em>*</em></label>
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

    <div class="mp-box-inputs mp-col-100" style="display:none;" id="mercadopago-utilities">
      <input type="text" name="site_id" id="site_id" />
      <input type="text" name="amount" id="amount" value="249.99"/>
      <input type="text" name="paymentMethodId" id="paymentMethodId"/>
      <input type="text" name="token" id="token"/>
    </div>
  </form>


  <!-- Until here -->

</div>


  <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
  <script>
    var mercadopago_site_id = '<?php echo $_REQUEST['site_id']; ?>';
    var mercadopago_public_key = '<?php echo MercadoPagoTest::getPublicKeyTest($_REQUEST['site_id']); ?>';
  </script>

  <script src="js/custom_checkout_mercadopago.js?no_cache=<?php echo time(); ?>"></script>




<?php
  include "html_test.php";
?>


</body>
