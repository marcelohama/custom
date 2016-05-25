// HFMPv1
// Handlers Form Mercado Pago v1

(function (){

  var HFMPv1 = {
    debug: false,
    add_truncated_card: true,
    site_id: '',
    public_key: '',
    create_token_on: {
      event: true, //if true create token on event, if false create on click and ignore others events. eg: paste or keyup
      keyup: false,
      paste: true,
    },
    inputs_to_create_token: [
      "cardNumber",
      "cardExpirationMonth",
      "cardExpirationYear",
      "cardholderName",
      "securityCode",
      "docType",
      "docNumber"
    ],
    selectors:{
      cardId: "#cardId",

      cardNumber: "#cardNumber",
      cardExpirationMonth: "#cardExpirationMonth",
      cardExpirationYear: "#cardExpirationYear",
      cardholderName: "#cardholderName",
      securityCode: "#securityCode",
      docType: "#docType",
      docNumber: "#docNumber",
      issuer: "#issuer",
      installments: "#installments",

      paymentMethodId: "#paymentMethodId",
      paymentMethodIdSelector: "#paymentMethodIdSelector",
      amount: "#amount",
      token: "#token",
      cardTruncated: "#cardTruncated",
      site_id: "#site_id",

      box_loading: "#mp-box-loading",
      submit: "#submit",
      form: '#mercadopago-form',
      utilities_fields: "#mercadopago-utilities"
    },
    text: {
      choose: "Choose",
      other_bank: "Other Bank"
    },
    paths:{
      loading: "images/loading.gif"
    }
  }

  HFMPv1.getBin = function () {
    var cardSelector = document.querySelector(HFMPv1.selectors.cardId);
    if (cardSelector && cardSelector[cardSelector.options.selectedIndex].value != "-1") {
      return cardSelector[cardSelector.options.selectedIndex].getAttribute('first_six_digits');
    }
    var ccNumber = document.querySelector(HFMPv1.selectors.cardNumber);
    return ccNumber.value.replace(/[ .-]/g, '').slice(0, 6);
  }

  HFMPv1.clearOptions = function () {
    var bin = HFMPv1.getBin();

    if (bin.length == 0) {
      HFMPv1.hideIssuer();

      var selectorInstallments = document.querySelector(HFMPv1.selectors.installments),
      fragment = document.createDocumentFragment(),
      option = new Option(HFMPv1.text.choose + "...", '-1');

      selectorInstallments.options.length = 0;
      fragment.appendChild(option);
      selectorInstallments.appendChild(fragment);
      selectorInstallments.setAttribute('disabled', 'disabled');
    }
  }

  HFMPv1.guessingPaymentMethod = function (event) {

    var bin = HFMPv1.getBin(),
    amount = document.querySelector(HFMPv1.selectors.amount).value;
    if (event.type == "keyup") {
      if (bin.length == 6) {
        Mercadopago.getPaymentMethod({
          "bin": bin
        }, HFMPv1.setPaymentMethodInfo);
      }
    } else {
      setTimeout(function() {
        if (bin.length >= 6) {
          Mercadopago.getPaymentMethod({
            "bin": bin
          }, HFMPv1.setPaymentMethodInfo);
        }
      }, 100);
    }
  };

  HFMPv1.setPaymentMethodInfo = function (status, response) {

    if (status == 200) {

      if(HFMPv1.site_id != "MLM"){
        //guessing
        document.querySelector(HFMPv1.selectors.paymentMethodId).value = response[0].id;
        document.querySelector(HFMPv1.selectors.cardNumber).style.background = "url(" + response[0].secure_thumbnail + ") 98% 50% no-repeat #fff";
      }

      // check if the security code (ex: Tarshop) is required
      var cardConfiguration = response[0].settings;
      bin = HFMPv1.getBin();
      amount = document.querySelector(HFMPv1.selectors.amount).value;

      Mercadopago.getInstallments({
        "bin": bin,
        "amount": amount
      }, HFMPv1.setInstallmentInfo);

      // check if the issuer is necessary to pay
      var issuerMandatory = false,
      additionalInfo = response[0].additional_info_needed;

      for (var i = 0; i < additionalInfo.length; i++) {
        if (additionalInfo[i] == "issuer_id") {
          issuerMandatory = true;
        }
      };
      if (issuerMandatory && HFMPv1.site_id != "MLM") {
        var payment_method_id = response[0].id;
        HFMPv1.getIssuersPaymentMethod(payment_method_id);
      } else {
        HFMPv1.hideIssuer();
      }
    }
  }


  HFMPv1.changePaymetMethodSelector = function (){

    var payment_method_id = document.querySelector(HFMPv1.selectors.paymentMethodIdSelector).value;
    HFMPv1.getIssuersPaymentMethod(payment_method_id);

  }


  /*
  *
  *
  * Issuers
  *
  */

  HFMPv1.getIssuersPaymentMethod = function (payment_method_id){
    Mercadopago.getIssuers(payment_method_id, HFMPv1.showCardIssuers);
    HFMPv1.addEvent(document.querySelector(HFMPv1.selectors.issuer), 'change', HFMPv1.setInstallmentsByIssuerId);
  }


  HFMPv1.showCardIssuers = function (status, issuers) {

    //if the API does not return any bank
    if(issuers.length > 0){
      var issuersSelector = document.querySelector(HFMPv1.selectors.issuer),
      fragment = document.createDocumentFragment();

      issuersSelector.options.length = 0;
      var option = new Option(HFMPv1.text.choose + "...", '-1');
      fragment.appendChild(option);

      for (var i = 0; i < issuers.length; i++) {
        if (issuers[i].name != "default") {
          option = new Option(issuers[i].name, issuers[i].id);
        } else {
          option = new Option("Otro", issuers[i].id);
        }
        fragment.appendChild(option);
      }
      issuersSelector.appendChild(fragment);
      issuersSelector.removeAttribute('disabled');
      //document.querySelector(HFMPv1.selectors.issuer).removeAttribute('style');
    }else{
      HFMPv1.hideIssuer();
    }
  }

  HFMPv1.setInstallmentsByIssuerId = function (status, response) {
    var issuerId = document.querySelector(HFMPv1.selectors.issuer).value,
    amount = document.querySelector(HFMPv1.selectors.amount).value;

    if (issuerId === '-1') {
      return;
    }

    Mercadopago.getInstallments({
      "bin": HFMPv1.getBin(),
      "amount": amount,
      "issuer_id": issuerId
    }, HFMPv1.setInstallmentInfo);
  }

  HFMPv1.hideIssuer = function (){
    var $issuer = document.querySelector(HFMPv1.selectors.issuer);
    var opt = document.createElement('option');
    opt.value = "-1";
    opt.innerHTML = HFMPv1.text.other_bank;

    $issuer.innerHTML = "";
    $issuer.appendChild(opt);
    $issuer.setAttribute('disabled', 'disabled');
  }

  /*
  *
  *
  * Installments
  *
  */

  HFMPv1.setInstallmentInfo = function(status, response) {
    var selectorInstallments = document.querySelector(HFMPv1.selectors.installments);

    if (response.length > 0) {

      var html_option = '<option value="-1">' + HFMPv1.text.choose + '...</option>';
      payerCosts = response[0].payer_costs;

      // fragment.appendChild(option);
      for (var i = 0; i < payerCosts.length; i++) {
        html_option += '<option value="'+ payerCosts[i].installments +'">' + (payerCosts[i].recommended_message || payerCosts[i].installments) + '</option>';
      }

      // not take the user's selection if equal
      if(selectorInstallments.innerHTML != html_option){
        selectorInstallments.innerHTML = html_option;
      }

      selectorInstallments.removeAttribute('disabled');
    }
  }


  /*
  *
  *
  * Customer & Cards
  *
  */

  HFMPv1.cardsHandler = function () {
    HFMPv1.clearOptions();
    var cardSelector = document.querySelector(HFMPv1.selectors.cardId),
    amount = document.querySelector(HFMPv1.selectors.amount).value;

    if (cardSelector && cardSelector[cardSelector.options.selectedIndex].value != "-1") {
      var _bin = cardSelector[cardSelector.options.selectedIndex].getAttribute("first_six_digits");
      Mercadopago.getPaymentMethod({
        "bin": _bin
      }, HFMPv1.setPaymentMethodInfo);
    }
  }

  /*
  * Payment Methods
  *
  */

  HFMPv1.getPaymentMethods = function(){
    var paymentMethodsSelector = document.querySelector(HFMPv1.selectors.paymentMethodIdSelector)

    //set loading
    paymentMethodsSelector.style.background = "url("+HFMPv1.paths.loading+") 95% 50% no-repeat #fff";

    Mercadopago.getAllPaymentMethods(function(code, payment_methods){
      fragment = document.createDocumentFragment();
      option = new Option(HFMPv1.text.choose + "...", '-1');
      fragment.appendChild(option);


      for(var x=0; x < payment_methods.length; x++){
        var pm = payment_methods[x];

        if((pm.payment_type_id == "credit_card" ||
        pm.payment_type_id == "debit_card" ||
        pm.payment_type_id == "prepaid_card") &&
        pm.status == "active"){

          option = new Option(pm.name, pm.id);
          fragment.appendChild(option);

        }//end if

      } //end for

      paymentMethodsSelector.appendChild(fragment);
      paymentMethodsSelector.style.background = "#fff";
    });
  }

  /*
  *
  * Functions related to Create Tokens
  *
  */


  HFMPv1.createTokenByEvent = function(){
    for(var x = 0; x < document.querySelectorAll('[data-checkout]').length; x++){
      var element = document.querySelectorAll('[data-checkout]')[x];

      //add events only in the required fields
      if(HFMPv1.inputs_to_create_token.indexOf(element.getAttribute("data-checkout")) > -1){

        var event = "focusout";

        if(element.nodeName == "SELECT"){
          event = "change";
        }

        HFMPv1.addEvent(element, event, HFMPv1.validateInputsCreateToken);

        if(HFMPv1.create_token_on.keyup){
          HFMPv1.addEvent(element, "keyup", HFMPv1.validateInputsCreateToken);
        }

        if(HFMPv1.create_token_on.paste){
          HFMPv1.addEvent(element, "paste", HFMPv1.validateInputsCreateToken);
        }

      }
    }
  }

  HFMPv1.createTokenBySubmit = function(){
    addEvent(document.querySelector(HFMPv1.selectors.form), 'submit', HFMPv1.doPay);
  }

  var doSubmit = false;

  HFMPv1.doPay = function(event){
    event.preventDefault();
    if(!doSubmit){
      HFMPv1.createToken();
      return false;
    }
  }


  HFMPv1.validateInputsCreateToken = function(){
    var valid_to_create_token = true;

    for(var x = 0; x < document.querySelectorAll('[data-checkout]').length; x++){
      var element = document.querySelectorAll('[data-checkout]')[x];

      //check is a input to create token
      if(HFMPv1.inputs_to_create_token.indexOf(element.getAttribute("data-checkout")) > -1){
        if(element.value == -1 || element.value == ""){
          valid_to_create_token = false;
        } //end if check values
      } //end if check data-checkout
    }//end for

    if(valid_to_create_token){
      HFMPv1.createToken();
    }
  }

  HFMPv1.createToken = function(){
    HFMPv1.hideErrors();

    //show loading
    document.querySelector(HFMPv1.selectors.box_loading).style.background = "url("+HFMPv1.paths.loading+") 0 50% no-repeat #fff";

    //form
    var $form = document.querySelector(HFMPv1.selectors.form);

    Mercadopago.createToken($form, HFMPv1.sdkResponseHandler);

    return false;
  }

  HFMPv1.sdkResponseHandler = function(status, response) {
    //hide loading
    document.querySelector(HFMPv1.selectors.box_loading).style.background = "";

    if (status != 200 && status != 201) {
      HFMPv1.showErrors(response);
    }else{
      var token = document.querySelector(HFMPv1.selectors.token);
      token.value = response.id;

      if(HFMPv1.add_truncated_card){
        var card = HFMPv1.truncateCard(response);
        document.querySelector(HFMPv1.selectors.cardTruncated).value=card;
      }

      if(!HFMPv1.create_token_on.event){
        doSubmit=true;
        btn = document.querySelector(HFMPv1.selectors.form);
        btn.submit();
      }
    }
  }

  /*
  *
  *
  * useful functions
  *
  */


  HFMPv1.truncateCard = function(response_card_token){
    var first_six_digits = response_card_token.first_six_digits.match(/.{1,4}/g)
    var card = first_six_digits[0] + " " + first_six_digits[1] + "** **** " + response_card_token.last_four_digits;
    return card;
  }

  /*
  *
  *
  * Show errors
  *
  */

  HFMPv1.showErrors = function(response){

    for(var x = 0; x < response.cause.length; x++){
      var error = response.cause[x];
      var $span = document.querySelector('#mp-error-' + error.code);
      var $input = document.querySelector($span.getAttribute("data-main"));

      $span.style.display = 'inline-block';
      $input.classList.add("mp-error-input");

    }

    return;
  }

  HFMPv1.hideErrors = function(){

    for(var x = 0; x < document.querySelectorAll('[data-checkout]').length; x++){
      var $field = document.querySelectorAll('[data-checkout]')[x];
      $field.classList.remove("mp-error-input");

    } //end for

    for(var x = 0; x < document.querySelectorAll('.mp-error').length; x++){
      var $span = document.querySelectorAll('.mp-error')[x];
      $span.style.display = 'none';

    }

    return;
  }

  /*
  *
  * Add events to guessing
  *
  */


  HFMPv1.addEvent = function(el, eventName, handler){
    if (el.addEventListener) {
      el.addEventListener(eventName, handler);
    } else {
      el.attachEvent('on' + eventName, function(){
        handler.call(el);
      });
    }
  };

  HFMPv1.addEvent(document.querySelector(HFMPv1.selectors.cardNumber), 'keyup', HFMPv1.guessingPaymentMethod);
  HFMPv1.addEvent(document.querySelector(HFMPv1.selectors.cardNumber), 'keyup', HFMPv1.clearOptions);
  HFMPv1.addEvent(document.querySelector(HFMPv1.selectors.cardNumber), 'change', HFMPv1.guessingPaymentMethod);
  HFMPv1.cardsHandler();




  /*
  *
  *
  * Initialization function
  *
  */

  HFMPv1.Initialize = function(site_id, public_key){

    //sets
    HFMPv1.site_id = site_id
    HFMPv1.public_key = public_key

    if(HFMPv1.create_token_on.event){
      HFMPv1.createTokenByEvent();
    }else{
      HFMPv1.createTokenBySubmit()
    }

    Mercadopago.setPublishableKey(HFMPv1.public_key);

    if(HFMPv1.site_id != "MLM"){
      Mercadopago.getIdentificationTypes();
    }

    if(HFMPv1.site_id == "MLM"){

      //hide documento for mex
      document.querySelector(".mp-doc").style.display = 'none';
      document.querySelector(".mp-paymentMethodsSelector").removeAttribute('style');

      //removing not used fields for this country
      HFMPv1.inputs_to_create_token.splice(HFMPv1.inputs_to_create_token.indexOf("docType"), 1);
      HFMPv1.inputs_to_create_token.splice(HFMPv1.inputs_to_create_token.indexOf("docNumber"), 1);

      HFMPv1.addEvent(document.querySelector(HFMPv1.selectors.paymentMethodIdSelector), 'change', HFMPv1.changePaymetMethodSelector);

      //get payment methods and populate selector
      HFMPv1.getPaymentMethods();
    }

    if(HFMPv1.site_id == "MLB"){

      document.querySelector(".mp-docType").style.display = 'none';
      document.querySelector(".mp-issuer").style.display = 'none';
      //ajust css
      document.querySelector(".mp-docNumber").classList.remove("mp-col-75");
      document.querySelector(".mp-docNumber").classList.add("mp-col-100");

    }else if (HFMPv1.site_id == "MCO") {
      document.querySelector(".mp-issuer").style.display = 'none';
    }

    document.querySelector(HFMPv1.selectors.site_id).value = HFMPv1.site_id;

    if(HFMPv1.debug){
      document.querySelector(HFMPv1.selectors.utilities_fields).style.display = 'inline-block';
      console.log(config_mp);
    }

    return;
  }


  this.HFMPv1 = HFMPv1;

}).call();
