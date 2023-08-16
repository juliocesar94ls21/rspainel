<?php
require_once("database/database.php");
require_once("model/classes/utilities.php");

$viewError = file_get_contents("view/infoError.tpl");

try {
	$db = new PDO('mysql:host='.HOST.';dbname='.BANCO, USER, PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("SET CHARACTER SET utf8");

	$dataLcr = 0;
	$dataCst = 0;
	$footerMargemLucro = 0;

	$query = "SELECT pedidos.*, clientes.nome FROM pedidos INNER JOIN clientes ON pedidos.clienteid = clientes.id where pedidos.entregue = 1 ORDER BY entrega ASC";
	$data = $db->query($query);
	foreach($data as $consulta){
			$query2 = "SELECT rs_pedidos_produtos.idproduto, produtos.preco, produtos.custo  FROM produtos INNER JOIN rs_pedidos_produtos ON rs_pedidos_produtos.idproduto = produtos.id WHERE rs_pedidos_produtos.idpedido = ".$consulta["id"];
			$data2p = $db->query($query2);
			$totalPedidoR = 0;
			$taxa = 0; //total de taxass
			foreach($data2p as $consulta2p){
				$dataLcr+= $consulta2p["preco"] - $consulta2p["custo"];
				$dataCst+= $consulta2p["custo"];
				$totalPedidoR+= $consulta2p["preco"];
			}
			$desconto = $consulta["descontoTipo"] == 0 ? ($consulta["descontoValor"] * $totalPedidoR) / 100 : $consulta["descontoValor"];
			$dataLcr-= $desconto;
			$stringPayment = strtolower(utilities::sanitizeString($consulta["pagamento"]));
			if($stringPayment == "credito" and $consulta["tipoparcela"] > 0){ //se pagamento for igual a crédito
				$queryTaxa = "select * from rs_x_taxas where id = ".$consulta["tipoparcela"];
				$consultaTaxa = $db->query($queryTaxa);
				$consultaTaxa = $consultaTaxa->fetchAll();
				$taxa+= $consultaTaxa[0]["tipo"] == 0 ? ($consultaTaxa[0]["valor"] * $totalPedidoR) / 100 : $consultaTaxa[0]["valor"];
			}
			if($stringPayment == "debito"){ //se pagamento for igual a débito
				$queryTaxa = "select * from rs_x_taxas where id = 1";
				$consultaTaxa = $db->query($queryTaxa);
				$consultaTaxa = $consultaTaxa->fetchAll();
				$taxa+= $consultaTaxa[0]["tipo"] == 0 ? ($consultaTaxa[0]["valor"] * $totalPedidoR) / 100 : $consultaTaxa[0]["valor"];
			}
			$queryTaxa = "select * from rs_x_taxas where id > 4 and aplicacao = 0"; //seleciona todas as taxas não aplicaveis ao cliente, diminui o lucro
			$dataTaxa = $db->query($queryTaxa);
			foreach($dataTaxa as $consultaTaxa){
				$taxa+= $consultaTaxa["tipo"] == 0 ? ($consultaTaxa["valor"] * $totalPedidoR) / 100 : $consultaTaxa["valor"];
			}
			$queryTaxaPedido = "SELECT rs_x_taxas.*, rs_z_pedidos_taxas.idtaxa FROM rs_x_taxas INNER JOIN rs_z_pedidos_taxas ON rs_x_taxas.id = rs_z_pedidos_taxas.idtaxa WHERE rs_z_pedidos_taxas.idpedido = ".$consulta["id"];
			$dataTaxaPedido = $db->query($queryTaxaPedido); //seleciona taxas dos pedidos aplicadas ao cliente aumenta o lucro
			foreach($dataTaxaPedido as $consultaTaxaPedido){
				$dataLcr+= $consultaTaxaPedido["tipo"] == 0 ? ($consultaTaxaPedido["valor"] * $totalPedidoR) / 100 : $consultaTaxaPedido["valor"];
			}
			$dataLcr-= $taxa; //taxa inclui tarifa de débito ou crédito, se for crédito calculo o tipo, "na hora", "em 14 dia", ou em "30" e as taxas aplicaveis a todas as vendas
			$dataCst+= $taxa;
		}
		$query3 = "SELECT * FROM `rs_x_gastos`";
		$data3 = $db->query($query3);
	
		foreach($data3 as $consulta3){
			$dataLcr-= $consulta3["custo"];
			$dataCst+= $consulta3["custo"];
		}
		$footerMargemLucro = ($dataCst * 100) / $dataLcr;
		$footerMargemLucro = number_format($footerMargemLucro, 1, ',', '.');
		$dataLcr = number_format($dataLcr, 2, ',', '.');
		$dataCst = number_format($dataCst, 2, ',', '.');
}
catch(PDOException $e) {
	$content = str_replace("{error}","Falha ao obter dados de lucros e custos : ".$e->getMessage(),$viewError);
	print $content;
	exit();
}
?>