<?php
require_once("../../database/database.php");
require_once("../classes/utilities.php");
date_default_timezone_set('America/Sao_Paulo');

$data = array();
$clienteId = $_POST["idClt"];
$action = $_POST["act"];

$parametros = array(
	"configuracoes" => array("tabela" => 0, "operacao" => 6), 
	"valores" => array("negativado" => $action),									 
	"condicao" => array("campo" => "id", "valor" => $clienteId)
);
$db = new database($parametros);

if($db->erro === null){
	$text = $action == 0 ? "reativado" : "negativado";
	$data["status"] = 1;
	$desc = 'Um cliente foi '.$text.", ID cliente - <b>".$clienteId."</b> ";
	utilities::setHistory($desc);
}else{
	$data["status"] = 0;
}

print json_encode($data);
?>