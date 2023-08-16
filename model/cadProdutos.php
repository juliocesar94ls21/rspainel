<?php
$content_return = file_get_contents("view/cadProdutos.tpl");
$rs_url = BASE_DIR."?controler=cadItem&submit=1&view=cadProdutos";
$content_return = str_replace("{url}",$rs_url,$content_return);
$viewSucess = file_get_contents("view/infoSucess.tpl");
$viewError = file_get_contents("view/infoError.tpl");
$post = array(
	"nome" => $_POST["nome"],
	"tamanho" => $_POST["tamanho"],
	"preco" => str_replace(",",".",$_POST["preco"]),
	"custo" => str_replace(",",".",$_POST["custo"]),
	"observacao" => $_POST["observacao"]
);

$parametros = array(
	"configuracoes" => array("tabela" => 2, "operacao" => 1),
	"valores" => $post 
);
$db = new database($parametros);
print $content_return;
if($db->erro === null){
	$content = str_replace("{mensagem}","Cadastrado com sucesso",$viewSucess);
	print $content;
	//historico
	$desc = $_SESSION["USER_NAME"].' cadastrou um produto, <b style="color:#737373;">'.$_POST["nome"].', </b>';
	utilities::setHistory($desc);
}else{
	$content = str_replace("{error}","Falha ao Cadastrar: ".$db->erro,$viewError);
	print $content;
}

?>