<?php
require_once("database/database.php");
require_once("config.php");

if(isset($_GET["updateEntrega"]) && $_GET["updateEntrega"] == true){
	$viewSucess = file_get_contents("view/infoSucess.tpl");
	$viewError = file_get_contents("view/infoError.tpl");
	$id = $_GET["itemid"];

	$parametros = array(
		"configuracoes" => array("tabela" => 1, "operacao" => 6),
		"valores" => array("entregue" => 1, "entrega" => date("Y-m-d")),
		"condicao" => array("campo" => "id", "valor" => $id)
	);
	$db = new database($parametros);

	if($db->erro === null){
		$contents = str_replace("{mensagem}","O pedido foi marcado como entregue",$viewSucess);
		$desc = 'Um <a href='.BASE_DIR.'?controler=infoItem&item=pedidos&itemid='.$id.'>Pedido</a> foi marcado como entregue';
		utilities::setHistory($desc);
	}else{
		$contents = str_replace("{error}","Falha ao atualizar pedido: ".$db->erro,$viewError);
	}
	print $contents;
}
?>