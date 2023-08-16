<?php
require_once("database/database.php");

$indexTable = (int)$_GET["itemIndex"];
$header = "<th>ID</th><th>Nome</th><th>Descrição</th><th>Valor</th><th></th><th></th><th></th>";
$tableFile = file_get_contents("view/table.tpl");
$url_del = UrlAtual();
$body = "";

$parametros = array(
	"configuracoes" => array("tabela" => $indexTable, "operacao" => 4),
	"column" => "all"
);
$db = new database($parametros);
$consulta = $db->recebeRegistros;
$nonDelete = array(0,1,2,3);

for($i = 0; $i < count($consulta); $i++){
	$tipo = $consulta[$i]["tipo"] == 0 ? "Porcentagem" : "Valor Fixo";
	$valor = $consulta[$i]["tipo"] == 0 ? "<b>".$consulta[$i]["valor"]."%</b>" : "<b>R$</b> ".$consulta[$i]["valor"];
	$body.= "<tr><td>".$consulta[$i]["id"]."</td><td>".$consulta[$i]["nome"]."</td><td>".$consulta[$i]["descricao"]."</td><td>"
	.$valor."</td>
	<td class='tb-icon' title='Atualizar'>
	<a class='load-gig' href='".BASE_DIR."?controler=atualizaItem&view=cadTaxa&submit=0&table=6&id=".$consulta[$i]["id"]."'>
		<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
	</a>
	</td>";
	if(!in_array($i,$nonDelete)){
	$body.= "<td class='tb-icon rs-btn-del' title='Deletar'>
		<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
	</td>";
	}else{
		$body.= '<td class="tb-block"><span style="opacity: 0.4;" class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></td>';
	}
	$body.= "<td>".$consulta[$i]["display"]."</td></tr>";
}
$content = str_replace(array("{header}","{body}","{indexMenu}","{url_del}","{id_del_tb}"),array($header,$body,4,$url_del,6),$tableFile);
print $content;
?>