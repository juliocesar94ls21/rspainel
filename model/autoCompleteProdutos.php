<?php
require_once("../database/database.php");

$nome = $_GET["nome"];	
	
$parametros = array(
	"configuracoes" => array("tabela" => 2, "operacao" => 4), // tabela é o indice da tabela por ordem alfabetica, operação é 1 para cadastro, 2 para atualização, 3 para remoção (tabela deve possuir campo adicional DISPLAY), 4 para seleção;
	"column" => "all", //coluna no caso de seleção.
	"clause" => "nome LIKE '%$nome%'" //condição, pode ser qualquer clause WHERE válida.
);
$db = new database($parametros);

//print_r($db->recebeRegistros);

$json = json_encode($db->recebeRegistros);
print $json;
	
?>