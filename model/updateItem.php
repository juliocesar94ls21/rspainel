<?php
require_once("database/database.php");
require_once("config.php");
//require_once("database/ADOdb-master/adodb.inc.php");

$view = file_get_contents("view/".$_GET["view"].".tpl");
$id = (int)$_GET["id"];
$rs_url = BASE_DIR."?controler=atualizaItem&view=".$_GET["view"]."&id=".$_GET["id"]."&submit=1&table=".$_GET["table"];
$table = (int)$_GET["table"];
$viewSucess = file_get_contents("view/infoSucess.tpl");
$viewError = file_get_contents("view/infoError.tpl");
$contents = null;

if($_GET["submit"] == 1){
	if($_GET["table"] == 11){
		if(isset($_POST["acesso"])){
			$_POST["acesso"] = 1;
		}else{
			$_POST["acesso"] = "0";
		}
	}
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
	if($_GET["table"] == 0){
		$desc = $_SESSION["USER_NAME"].' <b class="text-update">atualizou</b> um cliente, ID cliente - <b>'.$id.'</b> ';
		utilities::setHistory($desc);
	}
}

	$parametros = array(
		"configuracoes" => array("tabela" => $table, "operacao" => 4),
		"column" => "all",
		"clause" => "id = ".$id
	);
	$db = new database($parametros);
	$valuesTb = $db->recebeRegistros[0];
	
	$conn = new PDO('mysql:host='.HOST.';dbname='.BANCO, USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET CHARACTER SET utf8");
	
	$query = "SHOW COLUMNS FROM $db->tabela";
	$data = $conn->query($query);
	$columnsTb = array();
	
	foreach($data as $consulta){
		array_push($columnsTb, "{".$consulta["Field"]."}");
	}
	array_pop($columnsTb);
	array_shift($columnsTb);
	
	for($i = 0; $i < count($columnsTb); $i++){
		unset($valuesTb[$i]);
	}
	array_pop($valuesTb);
	array_shift($valuesTb);
	
	$content = str_replace($columnsTb,$valuesTb,$view);
	$content = str_replace("{url}",$rs_url,$content);
	
if($_GET["table"] == 0){
	$options = "";
	$parametros = array(
		"configuracoes" => array("tabela" => 9, "operacao" => 4),
		"column" => "id,nome"
	);
	$db = new database($parametros);
	for($i = 0; $i < count($db->recebeRegistros); $i++){
		$selected = $db->recebeRegistros[$i]["id"] == $valuesTb["cidadeid"] ? "selected='selected'" : "";
		$options.= "<option ".$selected." value='".$db->recebeRegistros[$i]["id"]."'>".$db->recebeRegistros[$i]["nome"]."</option>"; 
	} 
	$content = str_replace("{optionsCdd}",$options,$content);
}
if($_GET["table"] == 11){
	if($valuesTb["acesso"] == 1){
		$content = str_replace("{checked}","checked",$content);
	}
}
	
	print $content;
	print $contents;

?>
<script>
$(document).ready(function(){
	$(".btn-rs-submit input").val("Atualizar");
});
</script>