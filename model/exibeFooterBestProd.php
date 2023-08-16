<?php
require_once("database/database.php");

$dataArgs = array();
$dataConts = array();
$prodMax = "não indentificado";
$parametros = array(
	"configuracoes" => array("tabela" => 2, "operacao" => 4),
	"column" => "id,nome"
);
$db = new database($parametros);
$produtos = $db->recebeRegistros;

foreach($produtos as $prod){
	$parametros = array(
		"configuracoes" => array("tabela" => 3, "operacao" => 4),
		"column" => "id",
		"clause" => "idproduto = ".$prod["id"]
	);
	$db = new database($parametros);
	$dataArgs[] = array("nome" => $prod["nome"], "contVenda" => count($db->recebeRegistros));
	$dataConts[] = count($db->recebeRegistros);
}
$maxVendasProd = max($dataConts);

for($i = 0; $i < count($dataArgs); $i++){
	if($dataArgs[$i]["contVenda"] == $maxVendasProd){
		$prodMax = $dataArgs[$i]["nome"];
	}
}
?>