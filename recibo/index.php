<?php
//require_once("../dompdf/dompdf/dompdf_config.inc.php");
//$dompdf = new DOMPDF();

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//---------------------------------------//
	$host = "localhost";
	$banco = "rspainel";
	$user = "root";
	$pass = "3b59Rt6G@";
	$conn = new PDO('mysql:host='.$host.';dbname='.$banco, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET CHARACTER SET utf8");
	$totalAmount = 0;

	$query = "SELECT pedidos.*, clientes.id AS cid, clientes.observacao AS cobs, clientes.nome, clientes.telefone, clientes.email, clientes.rua,  clientes.numero,  clientes.bairro, clientes.complemento, rt_a_cidades.nome as cddNome, rt_a_cidades.frete FROM pedidos INNER JOIN clientes on pedidos.clienteid = clientes.id INNER JOIN rt_a_cidades on rt_a_cidades.id = clientes.cidadeid WHERE pedidos.id = ".$_GET["id"];
	$data = $conn->query($query);
	
	foreach($data as $consulta) {
		$infoPC = $consulta;
	}
	
	$dados["dataCltPdd"] = array(
	"referencia" => $infoPC["referencia"],
	"nome" => $infoPC["nome"], 
	"tel" => $infoPC["telefone"] == null ? "Não informado" : $infoPC["telefone"],
	"end" => $infoPC["rua"]." ".$infoPC["numero"],
	"cidade" => $infoPC["cddNome"],
	"bairro" => $infoPC["bairro"],
	"email" => $infoPC["email"] == null ? "Não informado" : $infoPC["email"],
	"entrega" => implode("/",array_reverse(explode("-",$infoPC["entrega"]))),
	"pagamento" => $infoPC["pagamento"],
	"frete" => "R$ ".number_format($infoPC["frete"],2,',','.'),
	"complemento" => $infoPC["complemento"] == null ? "Não informado" : $infoPC["complemento"]
	);
	
	$query2 = "SELECT produtos.*, rs_pedidos_produtos.cor, rs_pedidos_produtos.tmncustom FROM produtos INNER JOIN rs_pedidos_produtos ON rs_pedidos_produtos.idproduto = produtos.id WHERE rs_pedidos_produtos.idpedido = ".$_GET["id"];
	$data2 = $conn->query($query2);

	$descontoStr = $infoPC["descontoValor"] > 0 ? " (".$infoPC["descontoValor"]."%)" : "";
	$dados["desconto"] = $infoPC["descontoTipo"] == 0 ? number_format(($infoPC["descontoValor"] * $totalAmount) / 100,2,",",".").$descontoStr : number_format($infoPC["descontoValor"],2,",",".");
	if($infoPC["descontoValor"] == 0){$dados["desconto"] == 0;}
	
	foreach($data2 as $consulta2) {
			$dados["dataPdt"][] = array(
					"id" => $consulta2["id"],
					"nome" => ucfirst($consulta2["nome"]),
					"cor" => $consulta2["cor"],
					"taman" => $consulta2["tmncustom"],
					"preco" => str_replace(".",",",$consulta2["preco"])
			);
			$totalAmount+= $consulta2["preco"];
	}
			
	$dados["total"] = $totalAmount;
	$dados["total"]-= $infoPC["descontoTipo"] == 0 ? ($infoPC["descontoValor"] * $totalAmount) / 100 : $infoPC["descontoValor"];
	$dados["total"]+= $infoPC["frete"];
	
	$queryTaxaPedido = "SELECT rs_x_taxas.*, rs_z_pedidos_taxas.idtaxa FROM rs_x_taxas INNER JOIN rs_z_pedidos_taxas ON rs_x_taxas.id = rs_z_pedidos_taxas.idtaxa WHERE rs_z_pedidos_taxas.idpedido = ".$_GET["id"];
	$data3 = $conn->query($queryTaxaPedido);

	foreach($data as $consulta) {
		$infoPC = $consulta;
	}

	$dados["taxas"] = array();
		foreach($data3 as $consultaTaxaPedido) {
			$dados["taxas"][]= array("desc" => $consultaTaxaPedido["descricao"], "valor" => $consultaTaxaPedido["tipo"] == 0 ? number_format(($consultaTaxaPedido["valor"] * $totalAmount) / 100,2,",",".")." (".str_replace(".00","",$consultaTaxaPedido["valor"])."%)" : number_format($consultaTaxaPedido["valor"],2,",","."));
			$dados["total"]+= $consultaTaxaPedido["tipo"] == 0 ? ($consultaTaxaPedido["valor"] * $totalAmount) / 100 : $consultaTaxaPedido["valor"];
		}
	$dados["total"] = number_format($dados["total"],2,',','.');
	
	$queryVddr = "SELECT * FROM rs_usuarios WHERE id = ".$infoPC["vendedorid"];
	$data4 = $conn->query($queryVddr);
	
	foreach($data4 as $resultVddr){
		$dados["user_nome"] = $resultVddr["nome"];
		$dados["user_mail"] = $resultVddr["email"];
		$dados["user_tel"] = $resultVddr["telefone"];
	}
	
	//print_r($dados)
//-------------------------------------/
 
$semana = "%A";
		$mes = "%B";
		if(date("l") == "Tuesday"){
			$semana = "Terça";
		}
		if(date("l") == "Saturday"){
			$semana = "Sábado";
		}
		if(date("F") == "March"){
			$mes = "Março";
		}
		$data = ucfirst(strftime($semana.', %d de '.$mes.' de %Y', strtotime('Today')));
		
		$pasta_final = "PDF/Recibos/";
		
		$htmlProdutos = "";
		$produtos = $dados["dataPdt"];
		$produtosLenght = count($produtos);
		$scrolTop = 100;
		
		for($i = 0; $i < $produtosLenght; $i++){
			$id = $produtos[$i]["id"];
			$codId = "";
			$lenghtId = strlen($id);
			for($j = 0; $j < 5 - $lenghtId; $j++){
				$codId.= "0";
			}
			$codId.= $id;
			$htmlProdutos.= '<tr class="line_prod">
								<td>'.$codId.'</td><td style="text-transform:capitalize;">'.$produtos[$i]["nome"].'</td><td style="text-transform:capitalize;">'.$produtos[$i]["cor"].'</td><td>'.$produtos[$i]["taman"].'</td><td>R$ '.$produtos[$i]["preco"].'</td>
							</tr>';
		}
		if($produtosLenght < 4){
			for($i = 0; $i < 4 - $produtosLenght; $i++){
				$htmlProdutos.= '<tr class="line_prod">
						<td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
					</tr>';
			}
		}
		
		$htmlTaxas = '';
		$taxas = $dados["taxas"];
		$scrolTop+= 15;
		$scrolUnc = $scrolTop - 15;
		$taxasLenght = count($taxas);
		if($taxasLenght > 0){
			for($i = 0; $i < $taxasLenght; $i++){
				$htmlTaxas.= '<p>'.$taxas[$i]["desc"].': <b>R$ '.$taxas[$i]["valor"].'</b></p>';
			}
		}
		$desconto = $dados["desconto"];
		$htmlTaxas.= '<p>Desconto: <b>R$ '.$desconto.'</b></p>
					<p>Frete: <b>'.$dados["dataCltPdd"]["frete"].'</b></p>';
					
		//$dompdf = new DOMPDF();
 
		$html = '<!doctype html>
			<html>
			<head>
			<meta charset="UTF-8">
			<title>Recibo de Pagamento - Julio Cesar</title>
			<style>
			* { font-family: sans-serif; color: #252525}
			body{
				margin: 0;
				padding: 0;
			}
			.wrap-round{
				border: 1px solid #000;
			}
			.logo{
				width: 170px;
				position: absolute;
				left: 15px;
				top: -16px;
			}
			.header{
				position: relative;
				border-bottom: 1px solid #000;
				height: 45px;
			}
			.cel-top{
				width: 50%;
			}
			.cel-top p{
				margin: 8px 25px;
				font-size: 12px;
			}
			.line-header{
				font-size: 13px;
				font-weight: bold;
			}
			.line-header td{
				border-bottom: 1px solid #000;
				height: 24px;
				padding-left: 10px;
			}
			.line_prod td{
				border: 1px solid #808080;
				font-size: 12px;
				padding: 2px 8px;
			}
			.info_append_price{
				padding: 10px 0px;
				font-size: 12px;
				text-align: right;
				border-bottom: 0.7px solid #000;
			}
			.info_append_price p{
				margin: 2px 5px;
			}
			</style>
			</head>			 
			<body>
			<div class="wrap-round">
				<div class="header">
					<img class="logo" src="../img/comuns/Logo-RsMarcenaria.png" />
					<span style="position:absolute;right:20px;font-size:12px;font-weight:bold;top:15px;">Cód Referência: '.$dados["dataCltPdd"]["referencia"].'</span>
				</div>
				<table cellspacing="0" style="width:100%;">
					<tr>
						<td class="cel-top">
							<p><span>Nome: </span><span style="text-transform:capitalize;">'.$dados["dataCltPdd"]["nome"].'</span></p>
							<p><span>Telefone: </span><span>'.$dados["dataCltPdd"]["tel"].'</span></p>
							<p><span>Endereço: </span><span>'.$dados["dataCltPdd"]["end"].'</span></p>
							<p><span>Complemento: </span><span>'.$dados["dataCltPdd"]["complemento"].'</span></p>
							<p><span>Bairro: </span><span>'.ucfirst($dados["dataCltPdd"]["bairro"]).'</span></p>
							<p><span>Cidade: </span><span>'.ucfirst($dados["dataCltPdd"]["cidade"]).'</span></p>
						</td>
						<td class="cel-top">
							<p><span>Data da entrega: </span><span>'.$dados["dataCltPdd"]["entrega"].'</span></p>
							<p><span>Forma de pagamento: </span><span>'.$dados["dataCltPdd"]["pagamento"].'</span></p>
							<p><span>Vendedor: </span><span>'.ucfirst($dados["user_nome"]).'</span></p>
							<p><span>Telefone: </span><span>'.$dados["user_tel"].'</span></p>
							<p><span>Email: </span><span>'.$dados["user_mail"].'</span></p>
						</td>
					</tr>
				</table>
				<table cellspacing="0" style="width:100%;border-top: 1px solid #000;">
					<tr class="line-header">
						<td>Cód ID</td><td>Produto</td><td>Cor</td><td>Tamanho</td><td>Preço Unitário</td>
					</tr>
					'.$htmlProdutos.'
				</table>
				<div class="info_append_price">
					'.$htmlTaxas.'
				</div>
				<p style="font-size:13px;text-align:right;margin-right:10px;"><b>Total: R$ '.$dados["total"].'</b></p>
				<p style="font-size:12px; padding-left:10px;"><span>'.$data.'</span><span style="position:absolute; right:0px; margin-right: 10px;">Ass: ___________________________________</span></p>
			</div>
			</body>
			 
			</html>';
			
			print $html;
 
/* Renderiza 
$dompdf->render();
 
/* Exibe 
$dompdf->stream(
  "saida.pdf", /* Nome do arquivo de saída 
    array(
        "Attachment" => false /* Para download, altere para true 
    )
);*/
?>