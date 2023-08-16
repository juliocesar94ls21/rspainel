<?php
require_once("../../database/database.php");

$data = array();

$parametros = array(
	"configuracoes" => array("tabela" => 1, "operacao" => 4), 
	"column" => "id",
	"clause" => "fazendo = 1 and pronto = 0"
);
$db = new database($parametros);
if($db->erro === null){
	for($i = 0; $i < count($db->recebeRegistros); $i++){
		$data[]  = $db->recebeRegistros[$i]["id"];
	}
}else{
	$data["error"] = 1;
}
print json_encode($data);
?>