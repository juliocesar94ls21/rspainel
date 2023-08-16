<?php
session_start();
require_once("../config.php");
require_once("../database/database.php");

$pass = $_POST["pass"];

if($pass == "close"){
	unset($_SESSION["exibeganhos"]);
	$data["close"] = true;
}else{
	$getSenha = md5($pass);
	$data = array();
	$parametros = array(
			"configuracoes" => array("tabela" => 4, "operacao" => 4), 
			"column" => "all", 
			"clause" => sprintf("senha = '%s' and type = 1",$getSenha)
		);
	$db = new database($parametros);
	if($db->erro == null){
		if(count($db->recebeRegistros) == 0){
			$data["error"] = true;
			unset($_SESSION["exibeganhos"]);
		}else{
			$_SESSION["exibeganhos"] = true;
		}
	}else{
		$data["error"] = true;
	}
}
print(json_encode($data));
?>