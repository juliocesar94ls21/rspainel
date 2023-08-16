<?php
if(isset($_GET["updateAdmin"])){
	$viewSucess = file_get_contents("view/infoSucess.tpl");
	$viewError = file_get_contents("view/infoError.tpl");

	$parametros = array(
		"configuracoes" => array("tabela" => 4, "operacao" => 6), 
		"valores" => array("type" => (int)$_GET["action"]),									 
		"condicao" => array("campo" => "id", "valor" => $_GET["id"])
	);
	$db = new database($parametros);

	if($db->erro === null){
		$contents = str_replace("{mensagem}","Usuario alterado com sucesso",$viewSucess);
		print $contents;
	}else{
		$contents = str_replace("{error}","Falha ao Atualizar: ".$db->erro,$viewError);
		print $contents;
	}
}
?>