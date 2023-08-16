<?php
require_once("database/database.php");

$indexTable = 11;
$header = "<th>ID</th><th>Título</th><th>Descrição</th><th></th><th></th><th></th><th></th>";
$tableFile = file_get_contents("view/table.tpl");
$url_del = UrlAtual();
$body = "";
$contentBtn = '<a href="'.BASE_DIR.'?controler=cadItem&submit=0&view=cadAnotacao&indextb='.$indexTable.'"><span title="Criar" style="padding:6px 8px 7px 10px;" class="glyphicon glyphicon-plus btn-absolut-tb" aria-hidden="true"></span></a>';

$parametros = array(
	"configuracoes" => array("tabela" => $indexTable, "operacao" => 4),
	"column" => "all",
	"clause" => "userid = ".$_SESSION["USER_ID"]." or acesso = 1"
);
$db = new database($parametros);
$consulta = $db->recebeRegistros;

for($i = 0; $i < count($consulta); $i++){
	$body.= "<tr><td>".$consulta[$i]["id"]."</td>
		<td class='ucfisrt'>".$consulta[$i]["titulo"]."</td>
		<td>".$consulta[$i]["descricao"]."</td>
		<td class='tb-icon' title='Editar'>
			<a class='load-gig' href='".BASE_DIR."?controler=atualizaItem&view=cadAnotacao&submit=0&table=11&id=".$consulta[$i]["id"]."'>
				<span class='glyphicon glyphicon-th-list' aria-hidden='true'></span>
			</a>
		</td>
		<td class='tb-icon' title='Ver'>
			<a class='load-gig' target='_blank' href='".BASE_DIR."content/?itemid=".$consulta[$i]["id"]."'>
				<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
			</a>
		</td>
		<td class='tb-icon rs-btn-del cel-noborder' title='Deletar'>
			<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
		</td>";
	$body.= "<td>".$consulta[$i]["display"]."</td></tr>";
	
}
$content = str_replace(array("{header}","{body}","{url_del}","{id_del_tb}","{indexMenu}"),array($header,$body,$url_del,11,2),$tableFile);
print $contentBtn.$content;
if(count($consulta) == 0){
	print "<div class='info-empty-pronto'>Você não possui anotações cadastradas</div>";
}
?>