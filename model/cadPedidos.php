<?php
require_once("pushValues.php");
$content_return = file_get_contents("view/cadPedido.tpl");
$rs_url = BASE_DIR."?controler=cadItem&submit=1&view=cadPedido";
$content_return = str_replace(array("{url}","{optionsProd}","{optionsTaxa}"),array($rs_url,$options,$optionsTx),$content_return);
$content_return = str_replace("{icon-tools-action}","",$content_return);
$viewSucess = file_get_contents("view/infoSucess.tpl");
$viewError = file_get_contents("view/infoError.tpl");
$data = implode("-",array_reverse(explode("/",$_POST["entrega"])));
$date = new DateTime($data);
$data = $date->format('Y.m.d');

$post = array(
	"referencia" => $_POST["referencia"],
	"clienteid" => $_POST["clienteid"],
	"entrega" => $data,
	"pagamento" => $_POST["pagamento"],
	"entregue" => 0,
	"observacao" => $_POST["obs"],
	"tipoparcela" => $_POST["pagamento"] == "Crédito" ? $_POST["tipoparcela"] : 0,
	"descontoValor" => $_POST["descontoValor"] == null ? 0 : $_POST["descontoValor"],
	"descontoTipo" => $_POST["descontoTipo"] == null ? 0 : $_POST["descontoTipo"],
	"pronto" => 0,
	"vendedorid" => $_POST["vendedorid"],
	"fazendo" => 0
);

$parametros = array(
	"configuracoes" => array("tabela" => 1, "operacao" => 1),
	"valores" => $post 
);
$db = new database($parametros);
print $content_return;
if($db->erro === null){
	$id = $db->idInsert;
	$produtos = explode(",",$_POST["idPdts"]);
	$cores = explode(",",$_POST["corPdts"]);
	$tamanhos = explode("/",$_POST["sizePdts"]);
	for($i = 0; $i < count($produtos); $i++){
		$post  = array("idproduto" => $produtos[$i], "idpedido" => $id, "cor" => $cores[$i], "tmncustom" => $tamanhos[$i]); 
		$parametros2 = array(
				"configuracoes" => array("tabela" => 3, "operacao" => 1),
				"valores" => $post 
			);
		$db2 = new database($parametros2);
	}
	
	if($db2->erro === null){
		$taxas = isset($_POST["taxas"]) == true ? $_POST["taxas"] : null;
		if($taxas !== null){
			foreach($taxas as $taxa){
				$post = array("idpedido" => $id, "idtaxa" => $taxa); 
				$parametros3 = array(
						"configuracoes" => array("tabela" => 7, "operacao" => 1),
						"valores" => $post 
					);
				$db3 = new database($parametros3);
			}
			if($db3->erro === null){
				$content = str_replace("{mensagem}","Cadastrado com sucesso",$viewSucess);
				print $content;
			}else{
				$content = str_replace("{error}","Falha ao Cadastrar: ".$db3->erro,$viewError);
				print $content;
				exit();
			}
		}else{
			$content = str_replace("{mensagem}","Cadastrado com sucesso",$viewSucess);
			print $content;
		}
	}else{
		$content = str_replace("{error}","Falha ao Cadastrar: ".$db->erro,$viewError);
		print $content;
		exit();
	}
}else{
	$content = str_replace("{error}","Falha ao Cadastrar: ".$db->erro,$viewError);
	print $content;
	exit();
}

if($_SESSION["USER_TYPE"] != 1){
	$post = array(
		"gasto" => "Comissão",
		"custo" => TAXA_COMISSÃO * count($produtos),
		"data" => date("Y-m-d"),
		"observacao" => "Comissão referente ao pedido ".$_POST["referencia"].", cadastrado por ".$_SESSION["USER_NAME"]."."
	);
	$parametros = array(
		"configuracoes" => array("tabela" => 5, "operacao" => 1),
		"valores" => $post 
	);
	$db = new database($parametros);
}
//historico
$desc = $_SESSION["USER_NAME"].' <b class="text-cad">cadastrou</b> um pedido de referencia <b style="color:#737373;"><a href='.BASE_DIR.'?controler=infoItem&item=pedidos&itemid='.$id.'>'.$_POST["referencia"].'</a></b>';
utilities::setHistory($desc);
?>