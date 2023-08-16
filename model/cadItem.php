<?php
require_once("database/database.php");

$submit = (int)$_GET["submit"];
$indextb = null;
if(isset($_GET["indextb"])){
	$indextb = $_GET["indextb"];
}
if($_GET["view"] == "cadProdutos"){
	utilities::getPermission();
}
//formulario já foi submetido ?
if($_GET["submit"] == 0){
	$content = file_get_contents("view/".$_GET["view"].".tpl");
	$rs_url = BASE_DIR."?controler=cadItem&submit=1&view=".$_GET["view"]."&indextb=".$indextb;
	if($_GET["view"] == "cadPedido" ){
		require_once("pushValues.php");
		$content = str_replace(array("{url}","{optionsProd}","{optionsTaxa}","{idvd}"),array($rs_url,$options,$optionsTx,$_SESSION["USER_ID"]),$content); 
		$content = str_replace("{icon-tools-action}","",$content);
	}
	else if($_GET["view"] == "cadCliente" or $_GET["view"] == "cadastroRapido"){
		require_once("pushCidades.php");
		$content = str_replace(array("{url}","{optionsCdd}"),array($rs_url,$options),$content); 
	}
	else{
		$content = str_replace("{url}",$rs_url,$content);
	}
	if($_GET["view"] == "cadastroRapido" ){
		require_once("pushValues.php");
		$content = str_replace(array("{url}","{optionsProd}","{optionsTaxa}","{idvd}"),array($rs_url,$options,$optionsTx,$_SESSION["USER_ID"]),$content); 
	}
	$content = str_replace("{userid}",$_SESSION["USER_ID"],$content);
	$content = str_replace("{vendedorid}",$_SESSION["USER_ID"],$content);
	print $content;
}
if($_GET["submit"] == 1){
	if(isset($_GET["view"])){
		//caso produto
		if($_GET["view"] == "cadProdutos"){
			require_once("cadProdutos.php");
		}
		else if($_GET["view"] == "cadPedido"){
			require_once("cadPedidos.php");
		}
		else if($_GET["view"] == "cadastroRapido"){
			require_once("cadastroRapido.php");
		}
		//caso outros cadastros
		else{
			require_once("cadDefault.php");
		}
	}
	else{
		print "nenhuma view selecionada";
	}
}
?>
<script>
$(document).ready(function(){
	$(".content-forms").find("input[type=text]").val("");
	$(".content-forms").find("input[type=email]").val("");
	$(".content-forms").find("input[type=tel]").val("");
	$(".content-forms").find("textarea").val("");
});
</script>