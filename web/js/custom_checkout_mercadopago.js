var config_mp = {
  debug: true,
  add_truncated_card: true,
  site_id: mercadopago_site_id,
  public_key: mercadopago_public_key,
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
    choose: "Choose"
  },
  paths:{
    loading: "images/loading.gif"
  }
}

Initialize();

/*
*
*
* payment methods
*
*/

function getBin() {
  var cardSelector = document.querySelector(config_mp.selectors.cardId);
  if (cardSelector && cardSelector[cardSelector.options.selectedIndex].value != "-1") {
    return cardSelector[cardSelector.options.selectedIndex].getAttribute('first_six_digits');
  }
  var ccNumber = document.querySelector(config_mp.selectors.cardNumber);
  return ccNumber.value.replace(/[ .-]/g, '').slice(0, 6);
}

function clearOptions() {
  var bin = getBin();
  if (bin.length == 0) {
    hideIssuer();

    var selectorInstallments = document.querySelector(config_mp.selectors.installments),
    fragment = document.createDocumentFragment(),
    option = new Option(config_mp.text.choose + "...", '-1');

    selectorInstallments.options.length = 0;
    fragment.appendChild(option);
    selectorInstallments.appendChild(fragment);
    selectorInstallments.setAttribute('disabled', 'disabled');
  }
}

function guessingPaymentMethod(event) {

  var bin = getBin(),
  amount = document.querySelector(config_mp.selectors.amount).value;
  if (event.type == "keyup") {
    if (bin.length == 6) {
      Mercadopago.getPaymentMethod({
        "bin": bin
      }, setPaymentMethodInfo);
    }
  } else {
    setTimeout(function() {
      if (bin.length >= 6) {
        Mercadopago.getPaymentMethod({
          "bin": bin
        }, setPaymentMethodInfo);
      }
    }, 100);
  }
};

function setPaymentMethodInfo(status, response) {
  if (status == 200) {

    if(config_mp.site_id != "MLM"){
      //guessing
      document.querySelector(config_mp.selectors.paymentMethodId).value = response[0].id;
      document.querySelector(config_mp.selectors.cardNumber).style.background = "url(" + response[0].secure_thumbnail + ") 98% 50% no-repeat #fff";
    }



    // check if the security code (ex: Tarshop) is required
    var cardConfiguration = response[0].settings,
    bin = getBin(),
    amount = document.querySelector(config_mp.selectors.amount).value;

    for (var index = 0; index < cardConfiguration.length; index++) {
      if (bin.match(cardConfiguration[index].bin.pattern) != null && cardConfiguration[index].security_code.length == 0) {
        /*
        * In this case you do not need the Security code. You can hide the input.
        */
      } else {
        /*
        * In this case you NEED the Security code. You MUST show the input.
        */
      }
    }

    Mercadopago.getInstallments({
      "bin": bin,
      "amount": amount
    }, setInstallmentInfo);

    // check if the issuer is necessary to pay
    var issuerMandatory = false,
    additionalInfo = response[0].additional_info_needed;

    for (var i = 0; i < additionalInfo.length; i++) {
      if (additionalInfo[i] == "issuer_id") {
        issuerMandatory = true;
      }
    };
    if (issuerMandatory) {
      Mercadopago.getIssuers(response[0].id, showCardIssuers);
      addEvent(document.querySelector(config_mp.selectors.issuer), 'change', setInstallmentsByIssuerId);
    } else {
      hideIssuer();
    }
  }
};


/*
*
*
* Issuers
*
*/

function showCardIssuers(status, issuers) {

  var issuersSelector = document.querySelector(config_mp.selectors.issuer),
  fragment = document.createDocumentFragment();

  issuersSelector.options.length = 0;
  var option = new Option(config_mp.text.choose + "...", '-1');
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
  //document.querySelector(config_mp.selectors.issuer).removeAttribute('style');
};

function setInstallmentsByIssuerId(status, response) {
  var issuerId = document.querySelector(config_mp.selectors.issuer).value,
  amount = document.querySelector(config_mp.selectors.amount).value;

  if (issuerId === '-1') {
    return;
  }

  Mercadopago.getInstallments({
    "bin": getBin(),
    "amount": amount,
    "issuer_id": issuerId
  }, setInstallmentInfo);
};



function hideIssuer(){
  var $issuer = document.querySelector(config_mp.selectors.issuer);
  var opt = document.createElement('option');
  opt.value = "1";
  opt.innerHTML = "Other Bank";

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

function setInstallmentInfo(status, response) {
  var selectorInstallments = document.querySelector(config_mp.selectors.installments);

  if (response.length > 0) {

    var html_option = '<option value="-1">' + config_mp.text.choose + '...</option>';
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
};


/*
*
*
* Customer & Cards
*
*/

function cardsHandler() {
  clearOptions();
  var cardSelector = document.querySelector(config_mp.selectors.cardId),
  amount = document.querySelector(config_mp.selectors.amount).value;

  if (cardSelector && cardSelector[cardSelector.options.selectedIndex].value != "-1") {
    var _bin = cardSelector[cardSelector.options.selectedIndex].getAttribute("first_six_digits");
    Mercadopago.getPaymentMethod({
      "bin": _bin
    }, setPaymentMethodInfo);
  }
}


/*
* Payment Methods
*
*/

function getPaymentMethods(){
  var paymentMethodsSelector = document.querySelector(config_mp.selectors.paymentMethodIdSelector)

  //set loading
  paymentMethodsSelector.style.background = "url("+config_mp.paths.loading+") 95% 50% no-repeat #fff";

  Mercadopago.getAllPaymentMethods(function(code, payment_methods){
    fragment = document.createDocumentFragment();
    option = new Option(config_mp.text.choose + "...", '-1');
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


function createTokenByEvent(){
  for(var x = 0; x < document.querySelectorAll('[data-checkout]').length; x++){
    var element = document.querySelectorAll('[data-checkout]')[x];

    //add events only in the required fields
    if(config_mp.inputs_to_create_token.indexOf(element.getAttribute("data-checkout")) > -1){

      addEvent(element, "focusout", validateInputsCreateToken);
      addEvent(element, "change", validateInputsCreateToken);

      if(config_mp.create_token_on.keyup){
        addEvent(element, "keyup", validateInputsCreateToken);
      }

      if(config_mp.create_token_on.paste){
        addEvent(element, "paste", validateInputsCreateToken);
      }

    }
  }
}

function createTokenBySubmit(){
  addEvent(document.querySelector(config_mp.selectors.form), 'submit', doPay);
}

var doSubmit = false;

function doPay(event){
  event.preventDefault();
  if(!doSubmit){
    createToken();
    return false;
  }
};

function validateInputsCreateToken(){
  var valid_to_create_token = true;

  for(var x = 0; x < document.querySelectorAll('[data-checkout]').length; x++){
    var element = document.querySelectorAll('[data-checkout]')[x];

    //check is a input to create token
    if(config_mp.inputs_to_create_token.indexOf(element.getAttribute("data-checkout")) > -1){
      if(element.value == -1 || element.value == ""){
        valid_to_create_token = false;
      } //end if check values
    } //end if check data-checkout
  }//end for

  if(valid_to_create_token){
    createToken();
  }
}

function createToken(){
  hideErrors();

  //show loading
  document.querySelector(config_mp.selectors.box_loading).style.background = "url("+config_mp.paths.loading+") 0 50% no-repeat #fff";

  //form
  var $form = document.querySelector(config_mp.selectors.form);

  Mercadopago.createToken($form, sdkResponseHandler);

  return false;
}

function sdkResponseHandler(status, response) {
  //hide loading
  document.querySelector(config_mp.selectors.box_loading).style.background = "";

  if (status != 200 && status != 201) {
    showErrors(response);
  }else{
    var token = document.querySelector(config_mp.selectors.token);
    token.value = response.id;

    if(config_mp.add_truncated_card){
      var card = truncateCard(response);
      document.querySelector(config_mp.selectors.cardTruncated).value=card;
    }

    if(!config_mp.create_token_on.event){
      doSubmit=true;
      btn = document.querySelector(config_mp.selectors.form);
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


function truncateCard(response_card_token){
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

function showErrors(response){
  console.log(response);

  for(var x = 0; x < response.cause.length; x++){
    var error = response.cause[x];
    var $span = document.querySelector('#mp-error-' + error.code);
    var $input = document.querySelector($span.getAttribute("data-main"));

    $span.style.display = 'inline-block';
    $input.classList.add("mp-error-input");

  }

  return;
}

function hideErrors(){

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


function addEvent(el, eventName, handler){
  if (el.addEventListener) {
    el.addEventListener(eventName, handler);
  } else {
    el.attachEvent('on' + eventName, function(){
      handler.call(el);
    });
  }
};


addEvent(document.querySelector(config_mp.selectors.cardNumber), 'keyup', guessingPaymentMethod);
addEvent(document.querySelector(config_mp.selectors.cardNumber), 'keyup', clearOptions);
addEvent(document.querySelector(config_mp.selectors.cardNumber), 'change', guessingPaymentMethod);
cardsHandler();


/*
*
*
* Initialization function
*
*/

function Initialize(){

  if(config_mp.create_token_on.event){
    createTokenByEvent();
  }else{
    createTokenBySubmit()
  }

  Mercadopago.setPublishableKey(config_mp.public_key);

  if(config_mp.site_id != "MLM"){
    Mercadopago.getIdentificationTypes();
  }

  if(config_mp.site_id == "MLM"){

    //hide documento for mex
    document.querySelector(".mp-doc").style.display = 'none';
    document.querySelector(".mp-paymentMethodsSelector").removeAttribute('style');

    //removing not used fields for this country
    config_mp.inputs_to_create_token.splice(config_mp.inputs_to_create_token.indexOf("docType"), 1);
    config_mp.inputs_to_create_token.splice(config_mp.inputs_to_create_token.indexOf("docNumber"), 1);

    //get payment methods and populate selector
    getPaymentMethods();
  }

  if(config_mp.site_id == "MLB"){

    document.querySelector(".mp-docType").style.display = 'none';
    document.querySelector(".mp-issuer").style.display = 'none';
    //ajust css
    document.querySelector(".mp-docNumber").classList.remove("mp-col-75");
    document.querySelector(".mp-docNumber").classList.add("mp-col-100");

  }else if (config_mp.site_id == "MCO") {
    document.querySelector(".mp-issuer").style.display = 'none';
  }

  document.querySelector(config_mp.selectors.site_id).value = config_mp.site_id;

  if(config_mp.debug){
    document.querySelector(config_mp.selectors.utilities_fields).style.display = 'inline-block';
    console.log(config_mp);
  }
}
