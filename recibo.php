<?php
require_once("dompdf/dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data = ucfirst(strftime('%A, %d de %B de %Y', strtotime('today')));
 
$dompdf->load_html('<!doctype html>
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
				border-bottom: 1px solid #000;
			}
			.info_append_price p{
				margin: 2px 5px;
			}
			</style>
			</head>			 
			<body>
			<div class="wrap-round">
				<div class="header">
					<img class="logo" src="img/comuns/Logo-RsMarcenaria.png" />
					<span style="position:absolute;right:20px;font-size:12px;font-weight:bold;top:15px;">Cód Referência: KAXRMDREUF</span>
				</div>
				<table cellspacing="0" style="width:100%;">
					<tr>
						<td class="cel-top">
							<p><span>Nome: </span><span>Julio Cesar Santos</span></p>
							<p><span>Telefone: </span><span>(41)99782-2756</span></p>
							<p><span>Email: </span><span>Não informado</span></p>
							<p><span>Endereço: </span><span>Rua Emanuel Meira Martins, 47</span></p>
							<p><span>Bairro: </span><span>Cidade Industrial</span></p>
							<p><span>Cidade: </span><span>Curitiba</span></p>
						</td>
						<td class="cel-top">
							<p><span>Data da entrega: </span><span>21/01/2018</span></p>
							<p><span>Forma de pagamento: </span><span>Débito</span></p>
							<p><span>Vendedor: </span><span>Marcio Santos</span></p>
							<p><span>Telefone: </span><span>(44)99819-7954</span></p>
							<p><span>Email: </span><span>marciosantos@rsmarcenaria.com</span></p>
						</td>
					</tr>
				</table>
				<table cellspacing="0" style="width:100%;border-top: 1px solid #000;">
					<tr class="line-header">
						<td>Cód ID</td><td>Produto</td><td>Cor</td><td>Tamanho</td><td>Preço Unitário</td>
					</tr>
					<tr class="line_prod">
						<td>00002</td><td>Cabeceira Casal</td><td>Marrom Amassado</td><td>1,30x1,45x0,30</td><td>R$ 350,00</td>
					</tr>
					<tr class="line_prod">
						<td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="line_prod">
						<td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr class="line_prod">
						<td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
				<div class="info_append_price">
					<p>Taxa medida especial: <b>R$ 20,00</b></p>
					<p>Desconto: <b>R$ 0,00</b></p>
					<p>Frete: <b>R$ 0,00</b></p>
				</div>
				<p style="font-size:13px;text-align:right;margin-right:10px;"><b>Total: R$ 370,00</b></p>
				<p style="font-size:12px; padding-left:10px;"><span>Domingo, 07 de janeiro de 2018</span><span style="position:absolute; right:0px; margin-right: 10px;">Ass: ___________________________________</span></p>
			</div>
			</body>
			 
			</html>');
 
/* Renderiza */
$dompdf->render();
 
/* Exibe */
$dompdf->stream(
    "saida.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => false /* Para download, altere para true */
    )
);
?>
?>