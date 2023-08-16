<?php
require_once("database/database.php");

$dataArgs = array();
$dataConts = array();
$clienteMax = "não indentificado";
$parametros = array(
	"configuracoes" => array("tabela" => 0, "operacao" => 4),
	"column" => "id,nome"
);
$db = new database($parametros);
$clientes = $db->recebeRegistros;

foreach($clientes as $clt){
	$parametros = array(
		"configuracoes" => array("tabela" => 1, "operacao" => 4),
		"column" => "id",
		"clause" => "clienteid = ".$clt["id"]
	);
	$db = new database($parametros);
	$dataArgs[] = array("nome" => $clt["nome"], "contVenda" => count($db->recebeRegistros));
	$dataConts[] = count($db->recebeRegistros);
}
$maxVendasClt = count($dataConts) > 0 ? max($dataConts) : "Nehuma";

for($i = 0; $i < count($dataArgs); $i++){
	if($dataArgs[$i]["contVenda"] == $maxVendasClt){
		$clienteMax = $dataArgs[$i]["nome"];
	}
}
?>