<?php

include "lib/test.php";
include "lib/mercadopago.php";


if(!isset($_REQUEST['site_id'])){
  $_REQUEST['site_id'] = "MLA";
}

$mercadopago = new MP(MercadoPagoTest::getAccessTokenSellerTest($_REQUEST['site_id']));



if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_card'){
  $card_id = $_REQUEST['card_id'];
  $customer_id = $_REQUEST['customer_id'];
  $request = array(
      "uri" => "/v1/customers/" . $customer_id . "/cards/" . $card_id
  );

  $r = $mercadopago->delete($request);
  print_r($r);

}elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_customer') {
  $customer_id = $_REQUEST['customer_id'];
  $request = array(
      "uri" => "/v1/customers/" . $customer_id
  );

  $r = $mercadopago->delete($request);
  print_r($r);
}





$filters = array (
    "access_token" => $mercadopago->get_access_token()
);

$customers = $mercadopago->get ("/v1/customers/search", $filters);

?>

<table border="1">

  <tr>
    <td>Deletar Customer_id</td>
    <td>Deletar Cards</td>
  </tr>

<?php
foreach($customers['response']['results'] as $customer){
?>
  <tr>
    <td>

      <a href="?site_id=<?php echo $_REQUEST['site_id']; ?>&action=delete_customer&customer_id=<?php echo $customer['id']; ?>"><?php echo $customer['id']; ?></a>
    </td>
    <td>

      <ul>
        <?php foreach ($customer['cards'] as $card) { ?>
            <li>
              <a href="?site_id=<?php echo $_REQUEST['site_id']; ?>&action=delete_card&card_id=<?php echo $card['id']; ?>&customer_id=<?php echo $customer['id']; ?>"><?php echo $card['id']; ?></a>
            </li>
        <?php } ?>
      </ul>
    </td>
  </tr>
<?php
}
?>

</table>
