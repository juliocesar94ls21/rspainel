<?php
require_once("model/classes/utilities.php");

try {
	$db = new PDO('mysql:host='.HOST.';dbname='.BANCO, USER, PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("SET CHARACTER SET utf8");

	$dataLcr = 0; 
	$dataCst = 0;
	$viewError = file_get_contents("view/infoError.tpl"); //template de erro
	$viewContent = file_get_contents("view/exibeStatusFinanceiros.tpl"); //template da página
	$dataEnd = isset($_POST["data-end"]) ? implode("-",array_reverse(explode("/",$_POST["data-end"]))) : date("Y-m-d"); //ultima data para seleção
	$dataInit = isset($_POST["data-init"]) ? implode("-",array_reverse(explode("/",$_POST["data-init"]))) : date("Y-m-d", strtotime( "-1 month" )); //primeira data para seleção de dados
	$header = '<th>id</th><th>Referencia</th><th>Cliente</th><th>Data da entrega</th><th>Produtos</th><th>Lucro</th><th>Custo</th><th>Tarifas</th><th class="tb-icon"></th><th class="tb-icon"></th><th>display</th>';
	$headerDp = '<th>id</th><th></th><th>Custo</th><th>Data</th><th>Observacao</th><th></th><th>display</th>';
	$dataLucroMax = 0; //total máximo de lucros a ser exibido no "lucro máximo nesse pedíodo"
	$dataCustoMax = 0; //total máximo de custo a ser exibido "custo máximo nesse período"
	$totalLucrof = 0; //numero formatado, adiciona-se "f"
	$totalCustof = 0; //numero formatado
	$body = ""; //corpo da tabela pedido
	$bodyDp = ""; //corpo da tabela despesas
	$url_del = UrlAtual(); //url atual

	$query = "SELECT pedidos.*, clientes.nome FROM pedidos INNER JOIN clientes ON pedidos.clienteid = clientes.id where pedidos.entregue = 1 and (pedidos.entrega BETWEEN '$dataInit' AND '$dataEnd') ORDER BY entrega ASC"; //seleciona todos os pedidos em um intervalo de datas
	$data = $db->query($query);
 //começa executar as linhas dos pedidos
		$totalVendas = 0; //total de vendas
		$totalLucro = 0; //total de lucros
		$totalCusto = 0; //total de custos
		foreach($data as $consulta){//laço tabela pedidos
			$totalVendas+= 1;
			$countProd = 0;
			$date = $consulta["entrega"];
			$data = implode("/",array_reverse(explode("-",$date)));
			$query2 = "SELECT rs_pedidos_produtos.idproduto, produtos.preco, produtos.custo  FROM produtos INNER JOIN rs_pedidos_produtos ON rs_pedidos_produtos.idproduto = produtos.id WHERE rs_pedidos_produtos.idpedido = ".$consulta["id"];
			$data2 = $db->query($query2);
			$lucro = 0;
			$custo = 0;
			$totalPedido = 0;
			$taxa = 0; //total de taxass
			$taxaCredito = 0;
			$taxaDébito = 0;
			$demaisTaxas = 0;
			foreach($data2 as $consulta2){//laço tabela produtos
				$countProd+= 1;
				$totalPedido+= $consulta2["preco"];
				$lucro+= $consulta2["preco"] - $consulta2["custo"]; //lucro de cada pedido
				$custo+= $consulta2["custo"]; //custo de cada pedido
			}
			$desconto = $consulta["descontoTipo"] == 0 ? ($consulta["descontoValor"] * $totalPedido) / 100 : $consulta["descontoValor"];
			$lucro-= $desconto;
			$stringPayment = strtolower(utilities::sanitizeString($consulta["pagamento"]));
			if($stringPayment == "credito" and $consulta["tipoparcela"] > 0){ //se pagamento for igual a crédito
				$queryTaxa = "select * from rs_x_taxas where id = ".$consulta["tipoparcela"];
				$consultaTaxa = $db->query($queryTaxa);
				$consultaTaxa = $consultaTaxa->fetchAll();
				$taxa+= $consultaTaxa[0]["tipo"] == 0 ? ($consultaTaxa[0]["valor"] * $totalPedido) / 100 : $consultaTaxa[0]["valor"];
				$taxaCredito+= $consultaTaxa[0]["tipo"] == 0 ? ($consultaTaxa[0]["valor"] * $totalPedido) / 100 : $consultaTaxa[0]["valor"];
			}
			if($stringPayment == "debito"){ //se pagamento for igual a débito
				$queryTaxa = "select * from rs_x_taxas where id = 1";
				$consultaTaxa = $db->query($queryTaxa);
				$consultaTaxa = $consultaTaxa->fetchAll();
				$taxa+= $consultaTaxa[0]["tipo"] == 0 ? ($consultaTaxa[0]["valor"] * $totalPedido) / 100 : $consultaTaxa[0]["valor"];
				$taxaDébito+= $consultaTaxa[0]["tipo"] == 0 ? ($consultaTaxa[0]["valor"] * $totalPedido) / 100 : $consultaTaxa[0]["valor"];
			}
			$queryTaxa = "select * from rs_x_taxas where id > 4 and aplicacao = 0"; //seleciona todas as taxas não aplicaveis ao cliente, diminui o lucro
			$consultaTaxa = $db->query($queryTaxa);
			$dataTaxa = $consultaTaxa->fetchAll();
			if(count($consultaTaxa) > 0){
				foreach($dataTaxa as $consultaTaxa){
				$taxa+= $consultaTaxa["tipo"] == 0 ? ($consultaTaxa["valor"] * $totalPedido) / 100 : $consultaTaxa["valor"];
				$demaisTaxas+= $consultaTaxa["tipo"] == 0 ? ($consultaTaxa["valor"] * $totalPedido) / 100 : $consultaTaxa["valor"];
				}
			}
			$queryTaxaPedido = "SELECT rs_x_taxas.*, rs_z_pedidos_taxas.idtaxa FROM rs_x_taxas INNER JOIN rs_z_pedidos_taxas ON rs_x_taxas.id = rs_z_pedidos_taxas.idtaxa WHERE rs_z_pedidos_taxas.idpedido = ".$consulta["id"];
			$consultaTaxaPedido = $db->query($queryTaxaPedido); //seleciona taxas dos pedidos aplicadas ao cliente aumenta o lucro
			$dataTaxaPedido = $consultaTaxaPedido->fetchAll();
			if(count($consultaTaxaPedido) > 0){
				foreach($dataTaxaPedido as $consultaTaxaPedido){
					$lucro+= $consultaTaxaPedido["tipo"] == 0 ? ($consultaTaxaPedido["valor"] * $totalPedido) / 100 : $consultaTaxaPedido["valor"];
				}
			}
			$lucro-= $taxa; //taxa inclui tarifa de débito ou crédito, se for crédito calculo o tipo, "na hora", "em 14 dia", ou em "30" e as taxas aplicaveis a todas as vendas
			$custo+= $taxa;
			$taxaf = number_format($taxa, 2, ',', '.');
			$lucrof = number_format($lucro, 2, ',', '.');
			$custof = number_format($custo, 2, ',', '.');
			$totalLucro+= $lucro;
			$totalLucrof = number_format($totalLucro, 2, ',', '.');
			$totalCusto+= $custo;
			$totalCustof = number_format($totalCusto, 2, ',', '.');
			$textProd = $countProd == 1 ? " produto" : " produtos";
			$titleTaxa = $taxaCredito == 0 ? "" : "Taxa de Credito: R$".number_format($taxaCredito,2,',','.');
			$titleTaxa.= $taxaDébito == 0 ? "" : "  Taxa de Debito: R$".number_format($taxaDébito,2,',','.');
			$titleTaxa.= $demaisTaxas == 0 ? "" : "  Taxas Gerais: R$".number_format($demaisTaxas,2,',','.');
			$pathRcb = "PDF/Recibos/";
			$fileRcb = strtolower(implode("-",explode(" ",utilities::sanitizeString($consulta["nome"])))."-".$consulta["referencia"].".pdf");
			$body.= "<tr><td>".$consulta["id"]."</td><td title='".$consulta["referencia"]."'>".$consulta["referencia"]."</td><td title='".$consulta["nome"]."'>".$consulta["nome"]."</td><td>".$data."</td><td>".$countProd.$textProd."</td><td><b>R$</b> ".$lucrof."</td><td><b>R$</b> ".$custof."</td><td title='".$titleTaxa."'><b>R$</b> ".$taxaf."</td><td class='tb-icon' title='Ver Pedido'><a href='".BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$consulta["id"]."&hidebtn=true'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a></td><td class='tb-icon' title='Ver Recibo'><a target='blank' href='".BASE_DIR.$pathRcb.$fileRcb."'><span class='glyphicon glyphicon-open-file' aria-hidden='true'></span></a></td><td>".$consulta["display"]."</td></tr>";
		}
		$dataLucroMax+= $totalLucro; //soma todos os custos
		$dataCustoMax+= $totalCusto;
		$content = str_replace(array("{header}","{body}","{totalVendas}","{data-init}","{data-end}","{totalLucro}","{totalCusto}"),array($header,$body,$totalVendas,implode("/",array_reverse(explode("-",$dataInit))),implode("/",array_reverse(explode("-",$dataEnd))),$totalLucrof,$totalCustof),$viewContent);
		$query3 = "SELECT * FROM `rs_x_gastos` where data BETWEEN ('$dataInit') AND ('$dataEnd') ORDER BY data ASC";
		$data3 = $db->query($query3);
		$totalItens = 0;
		$totalCustos = 0;
			foreach($data3 as $consulta3){
				$totalItens+= 1;
				$totalCustos+= $consulta3["custo"];
				$bodyDp.= "<tr><td>".$consulta3["id"]."</td><td>".$consulta3["gasto"]."</td><td><b>R$</b> ".number_format($consulta3["custo"], 2, ',', '.')."</td><td>".implode("/",array_reverse(explode("-",$consulta3["data"])))."</td><td>".$consulta3["observacao"]."</td><td class='tb-icon rs-btn-del' title='Deletar'>
					<span class='glyphicon glyphicon-remove' aria-hidden='true'></span></td><td>".$consulta3["display"]."</td></tr>";
			}
			$dataLucroMax-= $totalCustos;
			$dataCustoMax+= $totalCustos;
			$dataCustoMax = $dataCustoMax < 0 ? 0 : $dataCustoMax;
			$dataLucroMax = $dataLucroMax < 0 ? 0 : $dataLucroMax;
			$content = str_replace(array("{headerTbdp}","{bodyTbdp}","{totalItens}","{totalCustoDp}","{totalLucroMax}","{totalDpMax}","{dir}"),array($headerDp,$bodyDp,$totalItens,number_format($totalCustos, 2, ',', '.'),number_format($dataLucroMax, 2, ',', '.'),number_format($dataCustoMax, 2, ',', '.'),$url_del),$content);
		print $content;
}
catch(PDOException $e) {
	$content = str_replace("{error}","Falha ao obter dados de lucros e custos : ".$e->getMessage(),$viewError);
	print $content;
	exit();
}
?>
