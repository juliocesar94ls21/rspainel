<?php
require_once("database/database.php");

$indexTable = 1;
$header = "<th>ID</th><th>nome</th><th>telefone</th><th>email</th><th>endereço</th><th>complemento</th><th>observação</th><th></th><th></th><th></th>";
$header.= $_SESSION["USER_TYPE"] == 1 ? "<th></th>" : "";
$header.= "<th>Display</th>";

$tableFile = file_get_contents("view/table.tpl");
$url_del = UrlAtual();
$body = "";
$clause = $_SESSION["USER_TYPE"] != 1 ? " and vendedorid = ".$_SESSION["USER_ID"] : "";

$parametros = array(
	"configuracoes" => array("tabela" => 0, "operacao" => 4),
	"column" => "all",
	"clause" => "negativado = 1".$clause
);
$db = new database($parametros);
$consulta = $db->recebeRegistros;

for($i = 0; $i < count($consulta); $i++){
	$parametros = array(
		"configuracoes" => array("tabela" => 1, "operacao" => 4),
		"column" => "id",
		"clause" => "clienteid = ".$consulta[$i]["id"]
	);
	$db = new database($parametros);
	$consulta2 = $db->recebeRegistros;
	$idPedido = count($consulta2) > 0 ? $consulta2[0]["id"] : "";

	$body.= "<tr><td>".$consulta[$i]["id"]."</td>
	<td title='".$consulta[$i]["nome"]."'>".$consulta[$i]["nome"]."</td>
	<td>".$consulta[$i]["telefone"]."</td>
	<td title='".$consulta[$i]["email"]."'>".$consulta[$i]["email"]."</td>
	<td title='".$consulta[$i]["rua"]." ".$consulta[$i]["numero"].", ".$consulta[$i]["bairro"]."'>".$consulta[$i]["rua"]." ".$consulta[$i]["numero"].", ".$consulta[$i]["bairro"]."</td>
	<td title='".$consulta[$i]["complemento"]."'>".$consulta[$i]["complemento"]."</td>
	<td title='".$consulta[$i]["observacao"]."'>".$consulta[$i]["observacao"]."</td>
	<td class='tb-icon' title='Exibir Pedido do cliente'>
		<a target='_blank' href='".BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$idPedido."&hidebtnprt=true'>
			<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
		</a>
	</td>";
	if($_SESSION["USER_TYPE"] == 1){
	$body.=	"<td class='tb-icon reativar' title='Reativar Cliente'><span class='glyphicon glyphicon-saved' aria-hidden='true'></span></td>";
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
	print "<div class='info-empty-pronto'>Nenhum cliente negativado</div>";
}
?>