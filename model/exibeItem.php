<?php
require_once("database/database.php");

$clause = null;
$rs_menu = 0;
$indexTable = (int)$_GET["itemIndex"];
//seleciona os menus ativos conforme variavel GET["itemIndex"], idice da tabela
switch($indexTable){
	case 0: $rs_menu = 1;
	break;
	case 1: $rs_menu = 2;
	break;
	case 2: $rs_menu = 0;
	break;
	case 9: $rs_menu = 1;
	break;
}
if(isset($_GET["clause"])){
	$rs = explode(".",$_GET["clause"]);
	$clause = array("chave" => $rs[0], "valor" => (int)$rs[1]);
}

new exibeItem($indexTable,$clause);

class exibeItem{
	function __construct($indexTable,$clause){
		$parametros = array(
			"configuracoes" => array("tabela" => $indexTable, "operacao" => 4),
			"column" => "all"
		);
		if($_GET["itemIndex"] == 0){
			$clause = $_SESSION["USER_TYPE"] != 1 ? "vendedorid = ".$_SESSION["USER_ID"] : "id > 0";
			$clauseNgtv = " and negativado = 0";
			$parametros["clause"] = $clause.$clauseNgtv;
		}
		$db = new database($parametros);
		$this->setView($db,$indexTable);
	}
	public function setView($db,$indexTable){
		$tableFile = file_get_contents("view/table.tpl");
		$header = "";
		$body = "";
		$dados = array();
		$colunas = $db->indicesColunas;
		$dados = $db->recebeRegistros;
		$url_del = UrlAtual();
		$colunas = $this->chekaSeCliente($colunas); //tratamento adicional para exibir clientes
		for($i = 0; $i < count($colunas); $i++){
			$header.= "<th>".$colunas[$i]."</th>";
			if($i == count($colunas) - 2){
				if($_GET["itemIndex"] !=2 and $_SESSION["USER_TYPE"] == 1 and $_GET["itemIndex"] == 0){
					//Negativar
					$header.= "<th></th>";
				}
				if($_GET["itemIndex"] !=2){
					$header.= "<th></th><th></th>";
				}else{
					if($_SESSION["USER_TYPE"] == 1){
						$header.= "<th></th><th></th>";
					}
				}
			}
		}
		//vai percorrer todos os arrays
		for($i = 0; $i < count($dados); $i++){
			//vai percorrer todas as colunas
			$body.= "<tr>";
			for($r = 0; $r < count($colunas); $r++){
				$body.= "<td title='".$dados[$i][$r]."'>".$dados[$i][$r]."</td>";
				if($r == count($colunas) - 1){
					$body.= "</tr>";
				}
				if($r == count($colunas) - 2){
					//Negativar
					if($_GET["itemIndex"] == 0 and $_SESSION["USER_TYPE"] == 1){
						$body.= "<td class='negative'><span title='Negativar cliente ?'>N</span></td>";
					}
					if($_GET["itemIndex"] !=2){
						$body.= "<td class='tb-icon' title='Atualizar'><a class='load-gig' href='".BASE_DIR."?controler=atualizaItem&view=".$_GET["view"]."&submit=0&table=".$_GET["table"]."&id=".$dados[$i][0]."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td><td class='tb-icon rs-btn-del' title='Deletar'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td>";
					}else{
						if($_SESSION["USER_TYPE"] == 1){
							$body.= "<td class='tb-icon' title='Atualizar'><a class='load-gig' href='".BASE_DIR."?controler=atualizaItem&view=".$_GET["view"]."&submit=0&table=".$_GET["table"]."&id=".$dados[$i][0]."'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span></a></td><td class='tb-icon rs-btn-del' title='Deletar'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td>";
						}
					}
				}
			}
		}
		global $rs_menu;
		$content = str_replace(array("{header}","{body}","{indexMenu}","{url_del}","{id_del_tb}"),array($header,$body,$rs_menu,$url_del,$indexTable),$tableFile);
		print_r($content);
	}
	public function chekaSeCliente($coluna){
		if($_GET["itemIndex"] == 0){
			$indexItem = count($coluna) - 1;
			$indexItem2 = $indexItem - 1;
			unset($coluna[$indexItem]);
			unset($coluna[$indexItem2]);
		}
		return $coluna;
	}
}
?>