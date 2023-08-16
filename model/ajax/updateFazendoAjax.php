<?php
session_start();
require_once("../../config.php");	
require_once("../../database/database.php");
require_once("../classes/utilities.php");
date_default_timezone_set('America/Sao_Paulo');

$idPedido = $_POST["idPedido"];
$data = array();

$parametros = array(
	"configuracoes" => array("tabela" => 1, "operacao" => 6), 
	"valores" => array("fazendo" => 1),									 
	"condicao" => array("campo" => "id", "valor" => $idPedido)
);
$db = new database($parametros);
if($db->erro === null){
	$data["status"] = 0;
	$desc = $_SESSION["USER_NAME"].' colocou um <a href='.BASE_DIR.'?controler=infoItem&item=pedidos&itemid='.$idPedido.'>Pedido</a> em andamento';
	utilities::setHistory($desc);
}else{
	$data["status"] = 1;
}
print json_encode($data);
?>