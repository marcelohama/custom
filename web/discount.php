<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

include "lib/mercadopago.php";
include "lib/test.php";

/*if (isset($_REQUEST['acao'])) {
    $cart = Context::getContext()->cart;
    $response = array(
        'status' => 200,
        'valor' => $cart->getOrderTotal(true, Cart::BOTH)
    );
} else {*/
    if (isset($_REQUEST['coupon_id']) && $_REQUEST['coupon_id'] != '') {
        $coupon_id = $_REQUEST['coupon_id'];
        $mercadopago = $this->module;
        $response = $mercadopago->validCoupon($coupon_id);
    } else {
        $response = array(
            'status' => 400,
            'response' => array(
                'error' => 'invalid_id',
                'message' => 'invalid id'
            )
        );
    }
echo "Marcelo T. Hama"
/*}
header('Content-Type: application/json');
echo Tools::jsonEncode($response);
exit();*/

?>

<br/>
<br/>

<pre>
  <?php echo json_encode($_REQUEST, JSON_PRETTY_PRINT); ?>
</pre>
<pre>
  <?php echo json_encode($payment, JSON_PRETTY_PRINT); ?>
</pre>
