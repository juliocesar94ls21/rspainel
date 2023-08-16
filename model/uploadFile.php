<?php
require_once("database/database.php");

function insertImageDB($foto){
	$id = (int)$_GET["idPdt"];
	$post = array("	imagem" => $foto, "idproduto" => $id);
	$parametros = array(
		"configuracoes" => array("tabela" => 8, "operacao" => 1),
		"valores" => $post 
	);
}

?>