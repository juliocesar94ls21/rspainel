<?php
	require_once("config.php");	
	require_once("model/classes/utilities.php");
	require_once("model/deleteItem.php");
	require_once("model/updateEntrega.php");
	require_once("model/updatePronto.php");
	require_once("model/exibeFooterBestProd.php");
	require_once("model/exibeFooterBestCliente.php");
	require_once("model/exibeFooterBestMonth.php");
	require_once("model/initials/updateAdmin.php");
	//carrega controlers
	switch($_GET["controler"]){
		//exibir um item
		case "exibeItem":
			if((int)$_GET["itemIndex"] == 1){
				require_once("model/tbPedidos.php");
			}
			else if((int)$_GET["itemIndex"] == 6){
				require_once("model/tbTaxa.php");
			}
			else if($_GET["itemIndex"] == "0"){
				require_once("model/tbCliente.php");
			}
			else if((int)$_GET["itemIndex"] == 8){
				require_once("model/upFiles.php");
			}
			else if($_GET["itemIndex"] == "galeria"){
				require_once("model/galeria.php");
			}
			else if($_GET["itemIndex"] == "prontaentrega"){
				require_once("model/prontaentrega.php");
			}
			else if($_GET["itemIndex"] == "pagamentos"){
				utilities::getPermission();
				require_once("model/mercadopago/pagamentos.php");
			}
			else if($_GET["itemIndex"] == "usuarios"){
				utilities::getPermission();
				require_once("model/tbUser.php");
			}
			else if($_GET["itemIndex"] == "negativados"){
				require_once("model/tbNegativados.php");
			}
			else if($_GET["itemIndex"] == "historico"){
				utilities::getPermission();
				require_once("model/historico.php");
			}
			else if($_GET["itemIndex"] == "anotacoes"){
				utilities::getPermission();
				require_once("model/anotacoes.php");
			}
			else{
				require_once("model/exibeItem.php");
			}
		break;
		/*--------------------------------*/
		case "cadItem":
			require_once("model/cadItem.php");
		break;
		/*--------------------------------*/
		case "infoItem":
			if($_GET["item"] == "pedidos"){
				require_once("model/infoPedidos.php");
			}
		break;
		case "content":
			require_once("model/content.php");
		break;
		/*--------------------------------*/
		case "atualizaItem":
			if($_GET["view"] == "cadPedido"){
				require_once("model/updatePedido.php");
			}
			else if($_GET["view"] == "cadTaxa"){
				require_once("model/updateTaxa.php");
			}
			else{
				require_once("model/updateItem.php");
			}
		break;
		/*--------------------------------*/
		case "deleteItem":
			require_once("model/deleteItem.php");
		break;
		/*--------------------------------*/
		case "statusFinancero":
			utilities::getPermission();
			require_once("model/exibeFinanceiro.php");
		break;
	}
?>