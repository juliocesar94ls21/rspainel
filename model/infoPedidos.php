<?php	

$viewError = file_get_contents("view/infoError.tpl");
$viewSucess = file_get_contents("view/infoSucess.tpl");
$id = (int)$_GET["itemid"];
$infoPC = array();
$dataRecibo = array();
$totalAmount = 0;

if($_GET["itemid"] == ""){
	print '<div class="rs-whrap-content">
	<div class="rs-row">
		<p class="rs-tab-title">Pedido</p>
	</div>
	<p style="text-align:  center;font-size: 22px;margin: 34px;"><span class="glyphicon glyphicon-remove" aria-hidden="true" style="position:  relative; top: 3px; left:  -6px;"></span>Pedido foi removido!</p></div>';
	exit();
}
try {
	$conn = new PDO('mysql:host='.HOST.';dbname='.BANCO, USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("SET CHARACTER SET utf8");

	$query = "SELECT pedidos.*, clientes.id AS cid, clientes.observacao AS cobs, clientes.nome, clientes.telefone, clientes.email, clientes.rua,  clientes.numero,  clientes.bairro, clientes.complemento, rt_a_cidades.nome as cddNome, rt_a_cidades.frete FROM pedidos INNER JOIN clientes on pedidos.clienteid = clientes.id INNER JOIN rt_a_cidades on rt_a_cidades.id = clientes.cidadeid WHERE pedidos.id = ".$id;
	$data = $conn->query($query);

	foreach($data as $consulta) {
		$infoPC = $consulta;
	}

$dataRecibo["dataCltPdd"] = array(
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
$query2 = "SELECT produtos.*, rs_pedidos_produtos.cor, rs_pedidos_produtos.tmncustom FROM produtos INNER JOIN rs_pedidos_produtos ON rs_pedidos_produtos.idproduto = produtos.id WHERE rs_pedidos_produtos.idpedido = ".$id;
$data2 = $conn->query($query2);

$descontoStr = $infoPC["descontoValor"] > 0 ? " (".$infoPC["descontoValor"]."%)" : "";
$dataRecibo["desconto"] = $infoPC["descontoTipo"] == 0 ? number_format(($infoPC["descontoValor"] * $totalAmount) / 100,2,",",".").$descontoStr : number_format($infoPC["descontoValor"],2,",",".");
if($infoPC["descontoValor"] == 0){$dataRecibo["desconto"] == 0;}
?>
<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Pedido <?php print $infoPC["referencia"] ?>
				<a class='load-gig icon-ifpd no-printable' href='<?php print BASE_DIR."?controler=atualizaItem&view=cadPedido&submit=0&table=1&id=".$id; ?>'>
					<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
				</a>
			</p>
	</div>
	<div class="container-fluid content-info-item">
		<div class="row">
			<p><b>Cliente:</b><span><b> <?php print ucfirst($infoPC["nome"]) ?></b></span>
				<a class='load-gig icon-ifpd no-printable' style="float: none;font-size: 18px;position: relative;top: 2px;" href='<?php print BASE_DIR."?controler=atualizaItem&view=cadCliente&submit=0&table=0&id=".$infoPC["cid"]; ?>'>
					<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
				</a>
			</p>
		</div>
		<div class="row produtos-tab">
			<p class="line"><b>Produtos:</b></p>
			<?php
		$arrayImpar = array(1,2,4,5,6,7);
		$impar = 1;
		$dataRecibo["dataPdt"] = array();
		foreach($data2 as $consulta2) {
			$dataRecibo["dataPdt"][] = array(
					"id" => $consulta2["id"],
					"nome" => ucfirst($consulta2["nome"]),
					"cor" => $consulta2["cor"],
					"taman" => $consulta2["tmncustom"],
					"preco" => str_replace(".",",",$consulta2["preco"])
			);
			$totalAmount+= $consulta2["preco"];
		?>
		<div class="col-md-4 item-prod" <?php if(in_array($impar,$arrayImpar)){ print "style='border-right: 1px solid #303030'"; } ?>>
				<p><b><?php print ucfirst($consulta2["nome"]) ?></b>
					<a class='load-gig icon-ifpd no-printable' style="float: none;font-size: 18px;position: relative;top: 2px;" href='<?php print BASE_DIR."?controler=atualizaItem&view=cadProdutos&submit=0&table=2&id=".$consulta2["id"]; ?>'>
					<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
				</a>
				</p>
				<p><b>Tamanho:</b> <span class="min-size-17"><?php $consulta2["tmncustom"] == null ? print "Não informado" : print $consulta2["tmncustom"];?></span></p>
				<p><b>Preço: </b><span class="min-size-17">R$ <?php print str_replace(".",",",$consulta2["preco"]) ?></span></p>
				<p><b>Cor:</b> <span class="min-size-17"><?php $consulta2["cor"] == null ? print "Não informada" : print $consulta2["cor"];?></span></p>
			</div>
			<?php
			$impar++;
		}
		?>
		</div>
		<div class="row cliente-tab">
			<p class="line line-top"><b>Dados do Cliente:</b></p>
			<div class="col-md-6">
				<p><b>Endereço:</b> <span class="min-size-17"><?php print $infoPC["rua"]." ".$infoPC["numero"].", ".$infoPC["bairro"].", ".$infoPC["cddNome"] ?></span></p>
			</div>
			<div class="col-md-6">
				<p><b>Complemento:</b> <span class="min-size-17"><?php $infoPC["complemento"] == null ? print "Não informado" : print $infoPC["complemento"];?></span></p>
			</div>
			<div class="col-md-6">
				<p><b>Telefone:</b> <span class="min-size-17"><?php $infoPC["telefone"] == null ? print "Não informado" : print $infoPC["telefone"];?></span></p>
			</div>
			<div class="col-md-6">
				<p><b>Email:</b> <span class="min-size-17"><?php $infoPC["email"] == null ? print "Não informado" : print $infoPC["email"];?></span></p>
			</div>
			<div class="col-md-6">
				<p><b>Observações:</b> <span class="obs"><?php $infoPC["cobs"] == null ? print "Nenhuma Observação" : print $infoPC["cobs"];?></span></p>
			</div>
		</div>
		<div class="row pedido-tab">
			<p class="line line-top"><b>Dados do Pedido:</b></p>
			<div class="col-md-6">
				<p><b>Data de entrega:</b> <span class="min-size-17"><?php print implode("/",array_reverse(explode("-",$infoPC["entrega"]))) ?></span></p>
			</div>
			<div class="col-md-6">
				<p><b>Forma de Pagamento: </b> <span class="min-size-17"><?php print $infoPC["pagamento"] ?></span></p>
			</div>
			<div class="col-md-6">
				<p><b>Frete: </b> <span class="min-size-17">R$ <?php print number_format($infoPC["frete"],2,',','.') ?></span></p>
			</div>
			<div class="col-md-6">
				<p><b>Desconto: </b> <span class="min-size-17">R$ <?php $infoPC["descontoTipo"] == 0 ? print number_format(($infoPC["descontoValor"] * $totalAmount) / 100,2,",",".").$descontoStr : print number_format($infoPC["descontoValor"],2,",","."); ?></span></p>
			</div>
			<div class="col-md-12">
				<p><b>Observações: </b> <span class="obs"><?php $infoPC["observacao"] == null ? print "Nenhuma Observação" : print $infoPC["observacao"];?></span></p>
			</div>
		</div>
	</div>
	<div class="action-td container-fluid actions-info">
		<div <?php if(isset($_GET["hidebtn"]) || $_SESSION["USER_TYPE"] != 1){print "style='display:none'";} ?> ><button title="O item será marcado como entregue e não aparecera nas buscas, aparecerá somente no histórico" class="botao-padrao"><a class="load-gig" href="<?php print $url = "http://" .$_SERVER['HTTP_HOST'].BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$_GET["itemid"]."&hidebtnprt=true&updateEntrega=1"; ?>">Entregue</a></button></div>
		<div <?php if(isset($_GET["hidebtn"]) or isset($_GET["hidebtnprt"]) or $_SESSION["USER_TYPE"] != 1){print "style='display:none'";} ?> ><button title="O item será marcado como pronto e só aparecerá nos menu 'Pronta Entrega'" class="botao-padrao"><a class="load-gig" href="<?php print $url = "http://" .$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI']."&updatePronto=1"; ?>">Pronto</a></button></div>
		<div><button title="Imprimir Pedido"  class="botao-padrao print-btn">Imprimir</button></div>
		<div <?php if(isset($_GET["hidebtnrcb"])){print "style='display:none'";} ?> ><button title="Gera recibo do cliente" class="botao-padrao"><a class="load-gig" href="<?php print $url = "http://" .$_SERVER['HTTP_HOST'].BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$_GET["itemid"]."&hidebtnprt=true&gerarRecibo=true"; ?>">Gerar Recibo</a></button></div>
		<div class="info-print">Obs: * Marque os pedidos entregue</div>
	</div>
</div>
<?php
$dataRecibo["total"] = $totalAmount;
$dataRecibo["total"]-= $infoPC["descontoTipo"] == 0 ? ($infoPC["descontoValor"] * $totalAmount) / 100 : $infoPC["descontoValor"];
$dataRecibo["total"]+= $infoPC["frete"];

$queryTaxaPedido = "SELECT rs_x_taxas.*, rs_z_pedidos_taxas.idtaxa FROM rs_x_taxas INNER JOIN rs_z_pedidos_taxas ON rs_x_taxas.id = rs_z_pedidos_taxas.idtaxa WHERE rs_z_pedidos_taxas.idpedido = ".$id;
$data3 = $conn->query($queryTaxaPedido);

foreach($data as $consulta) {
	$infoPC = $consulta;
}

$dataRecibo["taxas"] = array();
if($consultaTaxaPedido){
	foreach($data3 as $consultaTaxaPedido) {
		$dataRecibo["taxas"][]= array("desc" => $consultaTaxaPedido["descricao"], "valor" => $consultaTaxaPedido["tipo"] == 0 ? number_format(($consultaTaxaPedido["valor"] * $totalAmount) / 100,2,",",".")." (".str_replace(".00","",$consultaTaxaPedido["valor"])."%)" : number_format($consultaTaxaPedido["valor"],2,",","."));
		$dataRecibo["total"]+= $consultaTaxaPedido["tipo"] == 0 ? ($consultaTaxaPedido["valor"] * $totalAmount) / 100 : $consultaTaxaPedido["valor"];
	}
}

if(isset($_GET["gerarRecibo"])){
	$dataRecibo["total"] = number_format($dataRecibo["total"],2,',','.');
	$path = "PDF/Recibos/";
	$linkMail = "http://".$_SERVER['HTTP_HOST'].BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$_GET["itemid"]."&hidebtnprt=true&sendMail=true";
	$linkRcb = strtolower(implode("-",explode(" ",utilities::sanitizeString($infoPC["nome"])))."-".$infoPC["referencia"].".pdf");
	$dialogExec = '<div title="Recibo" class="dialog-rcb"><p>Recibo gerado com sucesso</p><p>deseja enviar ao email do cliente ?</p><form id="form-rcb" action="'.$linkMail.'" method="post"><input type="text" name="input-send-mail" class="input-send-mail" placeholder="Insira o email do cliente" value="'.$infoPC["email"].'" /><hr style="border-top: 1px solid #b3b3b3;"><button class="botao-stylis btn-send-mail-btn" style="margin-left: 10px;"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviar</button><button class="botao-stylis btn-preview-rcb" autofocus required><a target="_blank" href="'.$path.$linkRcb.'"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Prever</a></button></form></div>';
	$queryVddr = "SELECT * FROM rs_usuarios WHERE id = ".$infoPC["vendedorid"];
	$data4 = $conn->query($queryVddr);
	
	foreach($data4 as $resultVddr){
		$dataRecibo["user_nome"] = $resultVddr["nome"];
		$dataRecibo["user_mail"] = $resultVddr["email"];
		$dataRecibo["user_tel"] = $resultVddr["telefone"];
	}
	
	$recibo = utilities::geraRecibo($dataRecibo);
	if($recibo == true){
		print $dialogExec;
		$nome = strtolower(implode("-",explode(" ",utilities::sanitizeString($infoPC["nome"])))."-".$infoPC["referencia"].".pdf");
		$desc = $_SESSION["USER_NAME"].' gerou um <a target="_blank" href='.BASE_DIR.'PDF/Recibos/'.$nome.'>Recibo</a>';
		utilities::setHistory($desc);
	}else{
		$content = str_replace("{error}","Falha ao gerar recibo",$viewError);
		print $content;
		exit();
	}
}
if(isset($_GET["sendMail"])){
	$email = $_POST["input-send-mail"];
	$dados = array("nome" => $infoPC["nome"], "mail" => $email, "referencia" => $infoPC["referencia"]);
	$sendMail = utilities::sendRecibo($dados);
	if($sendMail === true){
		$content = str_replace("{mensagem}","Enviado com sucesso",$viewSucess);
		print $content;
	}else{
		$content = str_replace("{error}","Falha ao enviar recibo, ".$sendMail,$viewError);
		print $content;
		exit();
	}
}
if(isset($_GET["updatePronto"])){
	$linkMail = "http://".$_SERVER['HTTP_HOST'].BASE_DIR."?controler=infoItem&item=pedidos&itemid=".$_GET["itemid"]."&hidebtnprt=true&sendMailEntrega=true";
	$dialogExec = '<div title="Avisar entrega" class="dialog-rcb"><p>Pedido marcado como pronto,</p><p>Enviar email avisando cliente ?</p><form id="form-rcb" action="'.$linkMail.'" method="post"><input type="text" name="input-send-mail-entrega" class="input-send-mail" placeholder="Insira o email do cliente" value="'.$infoPC["email"].'" /><hr style="border-top: 1px solid #b3b3b3;"><button type="submit" autofocus class="botao-stylis btn-send-mail-btn" style="margin-left: 10px;"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Enviar</button></form></div>';
	if($erro_entrega == false){
		print $dialogExec;
	}
}
if(isset($_GET["sendMailEntrega"])){
	$email = $_POST["input-send-mail-entrega"];
	$dadosEntrega = array("nome" => $infoPC["nome"], "mail" => $email, "produtos" => $dataRecibo["dataPdt"]);
	$mailEntrega = utilities::mailEntrega($dadosEntrega);
	if($mailEntrega === true){
		$content = str_replace("{mensagem}","Enviado com sucesso",$viewSucess);
		print $content;
	}else{
		$content = str_replace("{error}","Falha ao enviar email, ".$sendMail,$viewError);
		print $content;
		exit();
	}
}
}catch(PDOException $e) {
	$content = str_replace("{error}","Falha ao obter dados: ".$e->getMessage(),$viewError);
	print $content;
	exit();
}
?>
<script>
	$(document).ready(function(){
		$( ".sidebar" ).accordion("option", "active", 2);
		$(".btn-preview-rcb").click(function(event){
			event.preventDefault();
			window.open($(this).children("a").attr("href"), '_blank');
		})
		$(".dialog-rcb").dialog({
			position: {my: "center", at: "top+300", of: window}
		});
	});
</script>