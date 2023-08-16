<?php
require_once("database/database.php");

if(isset($_GET["updatePronto"]) && $_GET["updatePronto"] == true){
	$viewSucess = file_get_contents("view/infoSucess.tpl");
	$viewError = file_get_contents("view/infoError.tpl");
	$id = $_GET["itemid"];

	$parametros = array(
		"configuracoes" => array("tabela" => 1, "operacao" => 6),
		"valores" => array("pronto" => 1),
		"condicao" => array("campo" => "id", "valor" => $id)
	);
	$db = new database($parametros);

	if($db->erro === null){
		$erro_entrega = false;
		if(isset($_GET["itemIndex"])){
			$contents = str_replace("{mensagem}","Pedido adicionado a pronta entrega",$viewSucess);
			$desc = $_SESSION["USER_NAME"].' adicionou um <a href='.BASE_DIR.'?controler=infoItem&item=pedidos&itemid='.$id.'>Pedido</a> a pronta entrega';
			utilities::setHistory($desc);
			print $contents;
		}
	}else{
		$erro_entrega = true;
		$contents = str_replace("{error}","Falha ao atualizar pedido: ".$db->erro,$viewError);
		print $contents;
	}
}
?>