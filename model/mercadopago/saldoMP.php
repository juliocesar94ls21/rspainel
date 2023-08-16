<?php
$nivelDir = "";
if(isset($_POST["ajax"])){
	$nivelDir = "../../";
}
require_once($nivelDir."config.php");
require_once($nivelDir."database/database.php");
require_once($nivelDir."mercado-pago/lib/mercadopago.php");

$dataMP = array();
$mp = new MP (CLIENTE_ID,CLIENTE_SECRET);
$balance = $mp->get ("/users/".USER_ID."/mercadopago_account/balance");

$dataMP["saldo"] = number_format($balance["response"]["total_amount"],2,",",".");

if(isset($_POST["ajax"])){
	print(json_encode($dataMP));
}
?>