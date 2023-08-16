<?php
require_once("database/database.php");

$indexTable = 4;
$header = "<th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th></th><th></th><th></th>";
$tableFile = file_get_contents("view/table.tpl");
$url_del = UrlAtual();
$body = "";
$link = BASE_DIR."?controler=exibeItem&itemIndex=usuarios&view=cadUser&table=0&updateAdmin=true&id=";

$parametros = array(
	"configuracoes" => array("tabela" => $indexTable, "operacao" => 4),
	"column" => "all"
);
$db = new database($parametros);
$consulta = $db->recebeRegistros;

for($i = 0; $i < count($consulta); $i++){
	if($consulta[$i]["id"] == $_SESSION["USER_ID"]){
		continue;
	}
	$action = $consulta[$i]["type"] == 1 ? "&action=2" : "&action=1";
	$icon = $consulta[$i]["type"] == 1 ? '<span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>' : "<span class='glyphicon glyphicon-circle-arrow-up' aria-hidden='true'></span>";
	$linki = $link.$consulta[$i]["id"].$action;
	$title = $consulta[$i]["type"] == 1 ? "Rebaixar para vendedor" : "Tornar administrador";
	$type = $consulta[$i]["type"] == 1 ? "Administrador" : "Vendedor";
	$body.= "<tr><td>".$consulta[$i]["id"]."</td><td class='ucfisrt'>".$consulta[$i]["nome"]."</td><td>".$consulta[$i]["email"]."</td><td>".$type."</td>";
	$body.= "<td class='tb-icon' title='".$title."'><a class='load-gig' href=".$linki.">".$icon."</a></td>";
	$body.= "<td class='tb-icon rs-btn-del' title='Deletar'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td>";
	$body.= "<td>".$consulta[$i]["display"]."</td></tr>";
}
$content = str_replace(array("{header}","{body}","{url_del}","{id_del_tb}","{indexMenu}"),array($header,$body,$url_del,4,2),$tableFile);
print $content;
?>