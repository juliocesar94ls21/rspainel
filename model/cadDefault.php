<?php
$content_return = file_get_contents("view/".$_GET["view"].".tpl");
$rs_url = BASE_DIR."?controler=cadItem&submit=1&view=".$_GET["view"]."&indextb=".$_GET["indextb"];
$content_return = str_replace("{url}",$rs_url,$content_return);
$viewSucess = file_get_contents("view/infoSucess.tpl");
$viewError = file_get_contents("view/infoError.tpl");
if(isset($_POST["senha"])){
	$_POST["senha"] = md5($_POST["senha"]);
}
if($_GET["indextb"] == 0){
	$_POST["negativado"] = 0;
	utilities::checkClienteNegativo($_POST);
	require_once("pushCidades.php");
	$content_return = str_replace(array("{url}","{optionsCdd}"),array($rs_url,$options),$content_return); 
}
if($_GET["indextb"] == 11){
	if(isset($_POST["acesso"])){
		unset($_POST["acesso"]);
		$_POST["acesso"] = 1;
	}else{
		$_POST["acesso"] = 0;	
	}
}
$parametros = array(
	"configuracoes" => array("tabela" => (int)$_GET["indextb"], "operacao" => 1),
	"valores" => $_POST 
);
$db = new database($parametros);
$content_return = str_replace("{userid}",$_SESSION["USER_ID"],$content_return);
print $content_return;
if($db->erro === null){
	if($_GET["indextb"] == 11){
		$content = str_replace("{mensagem}","Cadastrado com sucesso",$viewSucess);
	}
	else{
	$content = str_replace("{mensagem}","Cadastrado com sucesso",$viewSucess);
	print $content;
	}
	if($_GET["indextb"] == 0){
		//historico
		$desc = $_SESSION["USER_NAME"].' <b class="text-cad">cadastrou</b> um cliente, <b style="color:#737373;">'.$_POST["nome"].', </b>';
		utilities::setHistory($desc);
	}
}else{
	$content = str_replace("{error}","Falha ao Cadastrar: ".$db->erro,$viewError);
	print $content;
}
?>