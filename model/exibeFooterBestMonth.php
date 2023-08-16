<?php
require_once("database/database.php");

$dataArgs = array();
$dataConts = array();
$monthMax = "não indentificado";
$anoArgs = array("janeiro","fevereiro","março","abril","maio","junho","julho","agosto","setembro","outubro","novembro","dezembro");
$year = date("Y");
$i = 0;

foreach($anoArgs as $mont){
	$i++;
	$monthNumber = $i < 10 ? "0".$i : $i;
	$parametros = array(
		"configuracoes" => array("tabela" => 1, "operacao" => 4),
		"column" => "id",
		"clause" => "entrega BETWEEN ('".$year."-".$monthNumber."-01') AND ('".$year."-".$monthNumber."-31')"
	);
	$db = new database($parametros);
	$dataArgs[] = array("mes" => $mont, "contVenda" => count($db->recebeRegistros));
	$dataConts[] = count($db->recebeRegistros);
}
$maxVendasMonth = max($dataConts);

for($i = 0; $i < count($dataArgs); $i++){
	if($dataArgs[$i]["contVenda"] == $maxVendasMonth){
		$monthMax = $dataArgs[$i]["mes"];
	}
}
?>