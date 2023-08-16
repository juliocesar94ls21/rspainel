<?php
require_once("database/database.php");
require_once("config.php");

$view = file_get_contents("view/".$_GET["view"].".tpl");
$id = (int)$_GET["id"];
$rs_url = BASE_DIR."?controler=atualizaItem&view=".$_GET["view"]."&id=".$_GET["id"]."&submit=1&table=".$_GET["table"];
$table = (int)$_GET["table"];
$viewSucess = file_get_contents("view/infoSucess.tpl");
$viewError = file_get_contents("view/infoError.tpl");
$options = "";
$optionstx = "";
$produtosSelecionados = array();
$taxasSelecionados = array();
$allTaxas = array();
$contents = null;
$linkPrt = BASE_DIR."?controler=exibeItem&itemIndex=prontaentrega&updatePronto=true&itemid=".$id;
$linkEtg = BASE_DIR."?controler=exibeItem&itemIndex=1&updateEntrega=true&itemid=".$id;
$iconsTools = '<a class="load-gig icon-ifpd no-printable" href="'.$linkEtg.'" title="Marcar como entregue"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a><a class="load-gig icon-ifpd no-printable" style="margin-right:10px;" href="'.$linkPrt.'" title="Marcar como Pronto"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a>';

if($_GET["submit"] == 1){
	
	$post = array(
		"referencia" => $_POST["referencia"],
		"clienteid" => $_POST["clienteid"],
		"entrega" => implode("-",array_reverse(explode("/",$_POST["entrega"]))),
		"pagamento" => $_POST["pagamento"],
		"observacao" => $_POST["obs"],
		"tipoparcela" => $_POST["pagamento"] == "Crédito" ? $_POST["tipoparcela"] : "0",
		"descontoValor" => $_POST["descontoValor"] == null ? 0 : $_POST["descontoValor"],
		"descontoTipo" => $_POST["descontoTipo"] == null ? 0 : $_POST["descontoTipo"]
	);
	
	$parametros = array(
		"configuracoes" => array("tabela" => $table, "operacao" => 6),
		"valores" => $post,									 
		"condicao" => array("campo" => "id", "valor" => $id)
	);
	$db = new database($parametros);
	
	if($db->erro === null){
		//$contents = str_replace("{mensagem}","Atualizado com sucesso",$viewSucess);
		$parametrosdel = array(
			"configuracoes" => array("tabela" => 3, "operacao" => 5),  
			"condicao" => array("campo" => "idpedido", "valor" => $id) 
		);
		$db = new database($parametrosdel);
		
		$produtos = explode(",",$_POST["idPdts"]);
		$cores = explode(",",$_POST["corPdts"]);
		$tamanhos = explode("/",$_POST["sizePdts"]);
		for($i = 0; $i < count($produtos); $i++){
			$posts  = array("idproduto" => $produtos[$i], "idpedido" => $id, "cor" => $cores[$i], "tmncustom" => $tamanhos[$i]);
			$parametros2 = array(
				"configuracoes" => array("tabela" => 3, "operacao" => 1),
				"valores" => $posts 
			);
			$db2 = new database($parametros2);
		}
		if($db2->erro === null){
			$parametrosdel = array(
				"configuracoes" => array("tabela" => 7, "operacao" => 5),  
				"condicao" => array("campo" => "idpedido", "valor" => $id) 
			);
			$db = new database($parametrosdel);
			
			if(isset($_POST["taxas"])){
			$taxas = $_POST["taxas"];
				foreach($taxas as $taxa){
					$posts  = array("idpedido" => $id, "idtaxa" => $taxa); 
					$parametros3 = array(
						"configuracoes" => array("tabela" => 7, "operacao" => 1),
						"valores" => $posts 
					);
					$db3 = new database($parametros3);
				}
				if($db3->erro === null){
					$contents = str_replace("{mensagem}","Atualizado com sucesso",$viewSucess);
					print $contents;
				}else{
					$contents = str_replace("{error}","Falha ao Atualizar: ".$db3->erro,$viewError);
					print $contents;
					exit();
				}
			}else{
				$contents = str_replace("{mensagem}","Atualizado com sucesso",$viewSucess);
				print $contents;
			}
		}else{
			$contents = str_replace("{error}","Falha ao Atualizar: ".$db2->erro,$viewError);
			print $contents;
			exit();
		}
	}else{
		$contents = str_replace("{error}","Falha ao Atualizar: ".$db->erro,$viewError);
		print $contents;
		exit();
	}
	//historico
	$filterData=substr($_POST['img_value'], strpos($_POST['img_value'], ",")+1);
	$decodeData=base64_decode($filterData);
	$pathScreen = "img/screenshot/";
	$nameScreen = $_POST["referencia"].".png";
	file_put_contents($pathScreen.$nameScreen, $decodeData);
	$desc = $_SESSION["USER_NAME"].' <b class="text-update">atualizou</b> um pedido de referência <b style="color:#737373;"><a href='.BASE_DIR.'?controler=infoItem&item=pedidos&itemid='.$id.'>'.$_POST["referencia"].'</a></b>, <b style="color:#737373;"><a target="_blank" href='.$pathScreen.$nameScreen.'>dados anteriores</a></b>, atualizado';
	utilities::setHistory($desc);
}

$infoPC = array();
try{
	$db = new PDO('mysql:host='.HOST.';dbname='.BANCO, USER, PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("SET CHARACTER SET utf8");

	$query = "SELECT pedidos.*, clientes.nome, clientes.id as cid FROM pedidos INNER JOIN clientes on pedidos.clienteid = clientes.id WHERE pedidos.id = ".$id;
	$data = $db->query($query);
	foreach($data as $consulta){
		$infoPC = $consulta;
	}
	$content = str_replace(array("{referencia}","{cliente}","{entrega}","{obs}","{".$infoPC["pagamento"]."}","{idcl}","{desconto-".$infoPC["descontoTipo"]."}","{descontoValor}","{idvd}"),array($infoPC["referencia"],$infoPC["nome"],implode("/",array_reverse(explode("-",$infoPC["entrega"]))),$infoPC["observacao"],"selected",$infoPC["cid"],"selected",$infoPC["descontoValor"],$_SESSION["USER_ID"]),$view);
	if($infoPC["pagamento"] == "Crédito"){
		$content = str_replace("{credito-".$infoPC["tipoparcela"]."}","selected",$content);
	}

	$query2 = "SELECT produtos.*, rs_pedidos_produtos.* FROM produtos INNER JOIN rs_pedidos_produtos ON rs_pedidos_produtos.idproduto = produtos.id WHERE rs_pedidos_produtos.idpedido = ".$id;
	$data2 = $db->query($query2);
	$htmlItensPdt = '<div class="sub-itens-product">';
	foreach($data2 as $consulta2){
		$htmlItensPdt.= '<div class="row-itens"><input type="hidden" id="id_pdt_sub" value="'.$consulta2["idproduto"].'"><div class="col-md-1"><span>Produto: </span></div><div class="col-md-3"><input type="text" disabled value="'.$consulta2["nome"].'"></div><div class="col-md-1"><span>Cor: </span></div><div class="col-md-3"><input type="text" placeholder="Digite a Cor" value="'.$consulta2["cor"].'"></div><div class="col-md-1"><span>Tamanho: </span></div><div class="col-md-3"><input class="no-border" type="text" value="'.$consulta2["tmncustom"].'"></div><div class="remove-item-pdt"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div></div>';
	}

	$query3 = "SELECT rs_x_taxas.*, rs_z_pedidos_taxas.idpedido FROM rs_x_taxas INNER JOIN rs_z_pedidos_taxas ON rs_z_pedidos_taxas.idtaxa = rs_x_taxas.id WHERE rs_z_pedidos_taxas.idpedido = ".$id;
	$data3 = $db->query($query3);
	foreach($data3 as $consulta3){
		$taxasSelecionados[] = $consulta3["id"];
	}

	$query4 = "SELECT * from rs_x_taxas where id > 4 and aplicacao = 1";
	$data4 = $db->query($query4);
	foreach($data4 as $consulta4){
		$allTaxas[] = $consulta4;
	}

	for($i = 0; $i < count($allTaxas); $i++){
		if(in_array($allTaxas[$i]["id"],$taxasSelecionados)){
			$optionstx.= "<option selected='selected' value='".$allTaxas[$i]["id"]."'>".$allTaxas[$i]["nome"]."</option>";
		}else{
			$optionstx.= "<option value='".$allTaxas[$i]["id"]."'>".$allTaxas[$i]["nome"]."</option>";
		}
	}
	$content = str_replace(array('<div class="sub-itens-product"></div>',"{optionsTaxa}"),array($htmlItensPdt."</div>",$optionstx),$content);
	$content = str_replace("{url}",$rs_url,$content);
	$content = str_replace("{icon-tools-action}",$iconsTools,$content);
	print $content;
	
	//histórico
	if($_GET["submit"] == 1){
		
	}
}
catch(PDOException $e) {
	$content = str_replace("{error}","Falha ao obter dados: ".$e->getMessage(),$viewError);
	print $content;
	exit();
}
?>
<script type="text/javascript" src="js/html2canvas.js"></script>
<script>
$(document).ready(function(){
	$(".btn-rs-submit input").val("Atualizar");
	html2canvas(document.getElementById("content-center")).then(function(canvas) {
		$('#img_value').val(canvas.toDataURL("image/png"));
	});
});
</script>