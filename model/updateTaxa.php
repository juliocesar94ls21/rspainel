<?php
require_once("database/database.php");

$view = file_get_contents("view/".$_GET["view"].".tpl");
$id = (int)$_GET["id"];
$rs_url = BASE_DIR."?controler=atualizaItem&view=".$_GET["view"]."&id=".$_GET["id"]."&submit=1&table=".$_GET["table"];
$table = (int)$_GET["table"];
$viewSucess = file_get_contents("view/infoSucess.tpl");
$viewError = file_get_contents("view/infoError.tpl");
$contents = null;

if($_GET["submit"] == 1){
	$parametros = array(
		"configuracoes" => array("tabela" => $table, "operacao" => 2),
		"valores" => $_POST,									 
		"condicao" => array("campo" => "id", "valor" => $id)
	);
	$db = new database($parametros);
	if($db->erro === null){
		$contents = str_replace("{mensagem}","Atualizado com sucesso",$viewSucess);
	}else{
		$contents = str_replace("{error}","Falha ao Atualizar: ".$db->erro,$viewError);
	}
}
$parametros = array(
	"configuracoes" => array("tabela" => $table, "operacao" => 4),
	"column" => "all",
	"clause" => "id = ".$id
);
$db = new database($parametros);
$consulta = $db->recebeRegistros;

$content = str_replace(array("{nome}","{descricao}","{valor}","{".$consulta[0]["tipo"]."}","{valueAplTaxa}","{checked-".$consulta[0]["aplicacao"]."}","{url}"),array($consulta[0]["nome"],$consulta[0]["descricao"],$consulta[0]["valor"],"selected",$consulta[0]["aplicacao"],"checked",$rs_url),$view);

print $content;
print $contents;
?>
<script>
$(document).ready(function(){
	$(".btn-rs-submit input").val("Atualizar");
});
</script>