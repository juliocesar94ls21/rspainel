<?php
$erro = null;
$header = "<th>ID-tbpedidos</th><th>referencia</th><th>cliente</th><th>entrega</th><th>pagamento</th><th>produtos</th><th class='itemPreco'>total</th><th>observação</th><th class='no-printable'></th><th class='no-printable'></th><th class='no-printable cel-noborder'></th><th>display</th>";
$body = "";
$tableFile = file_get_contents("view/table.tpl");
$rs_menu = 2;
$containerEDT = '<span title="imprimir" class="glyphicon glyphicon-print btn-print-tb" aria-hidden="true"></span>';
$url_del = UrlAtual();
$clause_user = $_SESSION["USER_TYPE"] != 1 ? "and pedidos.vendedorid = ".$_SESSION["USER_ID"] : "";
$contPedidos = 0;

try {
	$conn = new PDO('mysql:host='.HOST.';dbname='.BANCO, USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET CHARACTER SET utf8");
	
	$query = "SELECT pedidos.*, clientes.nome, rs_usuarios.nome AS vnome FROM pedidos INNER JOIN clientes ON pedidos.clienteid = clientes.id INNER JOIN rs_usuarios ON rs_usuarios.id = pedidos.vendedorid where pedidos.entregue = 0 and pedidos.pronto = 0 and clientes.negativado = 0 ".$clause_user." ORDER BY entrega ASC";
    $data = $conn->query($query);
	
		 foreach($data as $consulta) {
			$contPedidos += 1;
			$countProd = 0;
			$nomesProd = "";
			$date = $consulta["entrega"];
			$data = implode("/",array_reverse(explode("-",$date)));
			$dataAtual = date("d/m/Y");
			$dataAmanha = date("d/m/Y", strtotime( "+1 day" ));
			$styleTr = '';
			$classData = '';
			if($data == $dataAmanha){
				$data = "Amanha";
				$styleTr = 'row-aviso';
				$classData = "td-aviso";
			}
			if($data == $dataAtual){
				$data = "Hoje";
				$styleTr = 'row-aviso-hj';
				$classData = "td-aviso-hj";
			}
			$styleTr.= $consulta["fazendo"] == 1 ? " pdd_emandamento" : "";
			$query2 = "SELECT rs_pedidos_produtos.idproduto, rs_pedidos_produtos.cor, rs_pedidos_produtos.tmncustom, produtos.preco, produtos.nome FROM produtos INNER JOIN rs_pedidos_produtos ON rs_pedidos_produtos.idproduto = produtos.id WHERE rs_pedidos_produtos.idpedido = ".$consulta["id"];
			$data2 = $conn->query($query2);
			$total = 0;
			$nomeExb = "";
			foreach($data2 as $consulta2) {
				$countProd+= 1;
				$total+= $consulta2["preco"];
				$nomesProd.= $consulta2["nome"]." ".$consulta2["cor"]." ".str_replace(",","",$consulta2["tmncustom"]).", ";
				$nomeExb.= $consulta2["nome"].", ";
			}
			$totalCheio = $total;
			$dataTaxa = 0;
			$queryTaxaPedido = "SELECT rs_x_taxas.*, rs_z_pedidos_taxas.idtaxa FROM rs_x_taxas INNER JOIN rs_z_pedidos_taxas ON rs_x_taxas.id = rs_z_pedidos_taxas.idtaxa WHERE rs_z_pedidos_taxas.idpedido = ".$consulta["id"];
			$data3 = $conn->query($queryTaxaPedido); //seleciona taxas dos pedidos aplicadas ao cliente aumenta o lucro
			if($data3){
				foreach($data3 as $consultaTaxaPedido) {
					$dataTaxa+= $consultaTaxaPedido["tipo"] == 0 ? ($consultaTaxaPedido["valor"] * $total) / 100 : $consultaTaxaPedido["valor"];
				}
			}
			$total+= $dataTaxa;
			$desconto = $consulta["descontoTipo"] == 0 ? ($consulta["descontoValor"] * $total) / 100 : $consulta["descontoValor"];
			$total-= $desconto;
			$textProd = $countProd == 1 ? " produto" : " produtos";
			$nomesProd = substr($nomesProd, 0, -2);
			$nomeExb = substr($nomeExb, 0, -2);
			$vnome = "";
			if($_SESSION["USER_TYPE"] == 1){
				$vnome = $consulta["observacao"] == "" ? "Vendedor - ".$consulta["vnome"] : " - Vendedor: ".$consulta["vnome"];
				$vnome = $consulta["vendedorid"] == $_SESSION["USER_ID"] ? $vnome." (Eu)" : $vnome;
			}
			$body.= "<tr class='".$styleTr."'>
				<td>".$consulta["id"]."</td><td title='".$consulta["referencia"]."'>".$consulta["referencia"]."</td>
				<td title='".$consulta["nome"]."' class='ucfisrt'>".$consulta["nome"]."</td>
				<td class='".$classData."'>".$data."</td><td>".$consulta["pagamento"]."</td>
				<td title='".$nomesProd."'>".$nomeExb."</td>
				<td title='Total de taxas: R$ ".number_format($dataTaxa,2,',','.').", Total de descontos: R$ ".number_format($desconto,2,',','.').", Total sem taxas e descontos: R$ ".number_format($totalCheio,2,',','.')."'>".$total."</td>
				<td title='".$consulta["observacao"].$vnome."'>".$consulta["observacao"].$vnome."</td>
				<td class='tb-icon' title='Ver'>
					<a class='load-gig' href='".BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$consulta["id"]."&hidebtnrcb=true'>
						<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>
					</a>
				</td>
				<td class='tb-icon' title='Atualizar'>
					<a class='load-gig' href='".BASE_DIR."?controler=atualizaItem&view=cadPedido&submit=0&table=1&id=".$consulta["id"]."'>
						<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
					</a>
				</td>
				<td class='tb-icon rs-btn-del cel-noborder' title='Deletar'>
					<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
				</td>
				<td>".$consulta["display"]."</td></tr>";
		}
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
$content = str_replace(array("{header}","{body}","{indexMenu}","{url_del}","{id_del_tb}"),array($header,$body,$rs_menu,$url_del,1),$tableFile);
$containerEDT.= $content;
print $containerEDT;
if($contPedidos == 0){
	print "<div class='info-empty-pronto'>Não há pedidos cadastrados no sistema</div>";
}
?>