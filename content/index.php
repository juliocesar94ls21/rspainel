<?php
require_once("../database/database.php");
$id = $_GET["itemid"];

$parametros = array(
	"configuracoes" => array("tabela" => 11, "operacao" => 4),
	"column" => "all",
	"clause" => "id = ".$id
);

$db = new database($parametros);
$consulta = $db->recebeRegistros;
print $consulta[0]["conteudo"];

?>