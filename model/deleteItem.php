<?php
require_once("database/database.php");

if(isset($_GET["submit"]) && $_GET["submit"] == true && isset($_POST["id-del"])){
	$id = (int)$_POST["id-del"];
	$table = (int)$_POST["tb-del"];
	$viewSucess = file_get_contents("view/infoSucess.tpl");
	$viewError = file_get_contents("view/infoError.tpl");
	
	if($table == 1){
		$stringRemove = '<div class="rs-whrap-content">';

		$string = utilities::url_get_contents("http://".$_SERVER['HTTP_HOST'].BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$id."&putFile=true");
		$string = explode($stringRemove,$string);
		$string = explode('<div class="action-td container-fluid actions-info">',$string[1]);
		$link1 = '<link href="../../css/global.css?v5.2" rel="stylesheet"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="https://fonts.googleapis.com/css?family=Raleway|Montserrat:900|Saira+Semi+Condensed" rel="stylesheet">
		<link href="../../bootstrap-3.3.7-dist\css\bootstrap.min.css" rel="stylesheet">
		<link href="css/override.css?v5.2" rel="stylesheet"/>
		<link rel="shortcut icon" type="image/png" href="img/comuns/favicon.png"/>';
		$string = $link1.'<div class="rs-whrap-content">'.$string[0];
		$path = "img/paginas/";
		$file = $id.".html";
		file_put_contents($path.$file, $string);
	}
	
	$parametros = array(
		"configuracoes" => array("tabela" => $table, "operacao" => 5),
		"condicao" => array("campo" => "id", "valor" => $id)
	);
	$db = new database($parametros);

	if($db->erro === null){
		if($table == 1){
			$parametros = array(
			"configuracoes" => array("tabela" => 3, "operacao" => 5),
			"condicao" => array("campo" => "idpedido", "valor" => $id)
			);
			$db = new database($parametros);
			if($db->erro === null){
				$contents = deletaTaxas($id,$viewSucess,$viewError,array("campo" => "idpedido", "valor" => $id));
	
				$desc = $_SESSION["USER_NAME"].' <b class="text-delete">deletou</b> um <b style="color:#737373;"><a target="_blank" href="img/paginas/'.$id.'.html">pedido</a></b>';
				utilities::setHistory($desc);
			}else{
				$contents = str_replace("{error}","Falha ao Remover: ".$db->erro,$viewError);
			}
		}else if($table == 0){
			$parametros = array(
			"configuracoes" => array("tabela" => 1, "operacao" => 5),
			"condicao" => array("campo" => "clienteid", "valor" => $id)
			);
			$db = new database($parametros);
			if($db->erro === null){
				$contents = str_replace("{mensagem}","Removido com sucesso",$viewSucess);
				$desc = $_SESSION["USER_NAME"].' <b class="text-delete">deletou</b> um cliente, ID cliente - <b>'.$id.' </b>';
				utilities::setHistory($desc);
			}else{
				$contents = str_replace("{error}","Falha ao Remover: ".$db->erro,$viewError);
			}
		}else if($table == 6){
			$contents = deletaTaxas($id,$viewSucess,$viewError,array("campo" => "idtaxa", "valor" => $id));
		}else if($table == 2){
			$desc = $_SESSION["USER_NAME"].' <b class="text-delete">deletou</b> um produto, ID produto - <b>'.$id.' </b>';
			utilities::setHistory($desc);
		}
		else{
			$contents = str_replace("{mensagem}","Removido com sucesso",$viewSucess);
		}
	}else{
		$contents = str_replace("{error}","Falha ao Remover: ".$db->erro,$viewError);
	}
	print $contents;
}

function deletaTaxas($id,$viewSucess,$viewError,$clause){
	$parametros = array(
		"configuracoes" => array("tabela" => 7, "operacao" => 5),
		"condicao" => $clause
	);
	$db = new database($parametros);
	if($db->erro === null){
		return str_replace("{mensagem}","Removido com sucesso",$viewSucess);
	}else{
		return str_replace("{error}","Falha ao Remover: ".$db->erro,$viewError);
	}
}
?>