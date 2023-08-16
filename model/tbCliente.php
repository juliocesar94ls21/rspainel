<?php
require_once("database/database.php");

$indexTable = 1;
$header = "<th>ID</th><th>nome</th><th>telefone</th><th>email</th><th>endereço</th><th>complemento</th><th>observação</th><th></th><th></th>";
$header.= $_SESSION["USER_TYPE"] == 1 ? "<th></th>" : "";
$header.= "<th>Display</th>";

$tableFile = file_get_contents("view/table.tpl");
$url_del = UrlAtual();
$body = "";
$clause = $_SESSION["USER_TYPE"] != 1 ? " and vendedorid = ".$_SESSION["USER_ID"] : "";

$parametros = array(
	"configuracoes" => array("tabela" => 0, "operacao" => 4),
	"column" => "all",
	"clause" => "negativado = 0".$clause
);
$db = new database($parametros);
$consulta = $db->recebeRegistros;

for($i = 0; $i < count($consulta); $i++){
	$parametros = array(
		"configuracoes" => array("tabela" => 9, "operacao" => 4),
		"column" => "nome",
		"clause" => "id = ".$consulta[$i]["cidadeid"]
	);
	$db = new database($parametros);
	$consulta2 = $db->recebeRegistros;
	$cidade = count($consulta2) > 0 ? $consulta2[0]["nome"] : "";

	$body.= "<tr><td>".$consulta[$i]["id"]."</td>
	<td title='".$consulta[$i]["nome"]."'>".$consulta[$i]["nome"]."</td>
	<td>".$consulta[$i]["telefone"]."</td>
	<td title='".$consulta[$i]["email"]."'>".$consulta[$i]["email"]."</td>
	<td title='".$consulta[$i]["rua"]." ".$consulta[$i]["numero"].", ".$consulta[$i]["bairro"].", ".$cidade."'>".$consulta[$i]["rua"]." ".$consulta[$i]["numero"].", ".$consulta[$i]["bairro"].", ".$cidade."</td>
	<td title='".$consulta[$i]["complemento"]."'>".$consulta[$i]["complemento"]."</td>
	<td title='".$consulta[$i]["observacao"]."'>".$consulta[$i]["observacao"]."</td>";
	if($_SESSION["USER_TYPE"] == 1){
	$body.=	"<td class='negative'><span title='Negativar cliente ?'>N</span></td>";
	}
	$body.=	"<td class='tb-icon' title='Atualizar'>
			<a class='load-gig' href='".BASE_DIR."?controler=atualizaItem&view=cadCliente&submit=0&table=0&id=".$consulta[$i]["id"]."'>
				<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
			</a>
		</td>
		<td class='tb-icon rs-btn-del' title='Deletar'>
			<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
		</td>";
	$body.= "<td>".$consulta[$i]["display"]."</td>";
	"</tr>";
}
$content = str_replace(array("{header}","{body}","{url_del}","{id_del_tb}","{indexMenu}"),array($header,$body,$url_del,0,1),$tableFile);
print $content;
if(count($consulta) == 0){
	print "<div class='info-empty-pronto'>Nenhum cliente cadastrado</div>";
}
?>