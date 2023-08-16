<?php
class utilities{
	public static function sanitizeString($string) {
		$what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );
		$by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );
		return str_replace($what, $by, $string);
	}
	public static function formatDate($data){
		return implode("/",array_reverse(explode("-",$data)));
	}
	public static function getCard($card){
		switch($card){
			case "credit_card":
				return "Crédito";
			break;
			case "debit_card":
				return "Débito";
			break;
		}
	}
	public static function getBandeira($bandeira){
		if(strripos(strtolower($bandeira),"visa") !== false){
			return "Visa";
		}
		else if(strripos(strtolower($bandeira),"elo") !== false){
			return "Elo";
		}
		else if(strripos(strtolower($bandeira),"master") !== false){
			return "Master";
		}
		else{
			return $bandeira;
		}
	}
	public static function getStatus($status){
		if(strtolower($status) == "approved"){
			return "Aprovado";
		}
		if(strtolower($status) == "pending"){
			return "Pendente";
		}
		if(strtolower($status) == "in_process"){
			return "Em Processo";
		}
		if(strtolower($status) == "rejected"){
			return "Rejeitado";
		}
		if(strtolower($status) == "refunded"){
			return "Devolvido";
		}
		if(strtolower($status) == "cancelled"){
			return "Cancelado";
		}
		if(strtolower($status) == "in_mediation"){
			return "Em Disputa";
		}
		if(strtolower($status) == "charged_back"){
			return "Contestado";
		}
	}
	public static function geraRecibo($dados){
		require_once("dompdf/dompdf/dompdf_config.inc.php");
		setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
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

		$dompdf = new DOMPDF();

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
					<img class="logo" src="img/comuns/Logo-RsMarcenaria.png" />
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

			</html>');

		$dompdf->render();

		$output = $dompdf->output();
		$fileName = strtolower(implode("-",explode(" ",utilities::sanitizeString($dados["dataCltPdd"]["nome"])))."-".$dados["dataCltPdd"]["referencia"].".pdf");
		if(file_put_contents($pasta_final.$fileName, $output)){
			return true;
		}else{
			return false;
		}
	}
	public static function sendRecibo($dados){
		require_once("mail.php");
		$nome = explode(" ",$dados["nome"]);
		$nome = ucfirst($nome[0]);
		$mailUser = $dados["mail"];
		$path = "PDF/Recibos/";
		$recibo = strtolower(implode("-",explode(" ",utilities::sanitizeString($dados["nome"])))."-".$dados["referencia"].".pdf");

		$mail->From = "rsmarcenaria@rsmarcenaria.com";
		$mail->FromName = "RSMarcenaria";

		$mail->AddAddress($mailUser, $nome);

		$mail->IsHTML(true);

		$mail->Subject  = "Recibo da sua compra";
		$mail->Body = "Olá ".$nome.", obrigado por comprar conosco, segue em anexo o recibo da sua compra!";

		$mail->AddAttachment($path.$recibo, "recibo.pdf");

		$enviado = $mail->Send();

		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		if ($enviado) {
		  return true;
		} else {
		  return $mail->ErrorInfo;
		}
	}
	public static function mailEntrega($dados){
		require_once("mail.php");
		$nome = explode(" ",$dados["nome"]);
		$nome = ucfirst($nome[0]);
		$mailUser = $dados["mail"];
		$htmlProdutos = "";
		foreach($dados["produtos"] as $produto){
			$htmlProdutos.= "<p><b>".ucfirst($produto["nome"])."</b> na cor <b>".ucfirst($produto["cor"])."</b>.</p>";
		}
		$produtosText = count($dados["produtos"]) == 1 ? "seu produto está pronto" : "seus produtos estão pronto";
		$msg = "<p>Olá ".$nome.", esse email foi enviado para lhe informar que ".$produtosText.", entre em contato para combinar a entrega.</p><p><b>Seu pedido:</b></p>".$htmlProdutos;

		$mail->From = "rsmarcenaria@rsmarcenaria.com";
		$mail->FromName = "RSMarcenaria";

		$mail->AddAddress($mailUser, $nome);

		$mail->IsHTML(true);

		$mail->Subject  = "Seu produto esta pronto";
		$mail->Body = $msg;

		$enviado = $mail->Send();

		$mail->ClearAllRecipients();
		$mail->ClearAttachments();

		if ($enviado) {
		  return true;
		} else {
		  return $mail->ErrorInfo;
		}
	}
	public static function getPermission(){
		if($_SESSION["USER_TYPE"] != 1){
			$content = file_get_contents("view/sempermissao.tpl");
			print $content;
			exit();
		}
	}
	public static function checkClienteNegativo($post){
		$clt_negativado = false;
		$viewError = file_get_contents("view/infoError.tpl");
		$viewContent = file_get_contents("view/cadCliente.tpl");
		$rs_url = BASE_DIR."?controler=cadItem&submit=1&view=cadCliente&indextb=0";
		$viewContent = str_replace("{url}",$rs_url,$viewContent);
		$parametros = array(
			"configuracoes" => array("tabela" => 0, "operacao" => 4),
			"column" => "all",
			"clause" => "negativado = 1"
		);
		$db = new database($parametros);
		$negativados = $db->recebeRegistros;
		$cliente = "";

		for($i = 0; $i < count($negativados); $i++){
			if(strtolower($post["nome"]) == strtolower($negativados[$i]["nome"])){
				$clt_negativado = true;
				$cliente = $negativados[$i]["nome"];
				break;
			}
			if(strtolower($post["telefone"]) == strtolower($negativados[$i]["telefone"])){
				$clt_negativado = true;
				$cliente = $negativados[$i]["nome"];
				break;
			}
			if($post["cep"] == $negativados[$i]["cep"] and strtolower($post["numero"]) == strtolower($negativados[$i]["numero"])){
				$clt_negativado = true;
				$cliente = $negativados[$i]["nome"];
				break;
			}
		}
		if($clt_negativado == true){
			$content = str_replace("{error}","<b>Cadastro Bloqueado</b><br><br> Seu cadastro foi bloqueado por cruzar informações com um cliente negativado na base de dados.<br> Nenhum pedido pode ser cadastrado em nome de <b>".$cliente."</b> até que seu cadastro seja reativado",$viewError);
			print $viewContent;
			print $content;
			print '<script>
				$(document).ready(function(){
					$(".content-forms").find("input[type=text]").val("");
					$(".content-forms").find("input[type=email]").val("");
					$(".content-forms").find("input[type=tel]").val("");
				});
			</script>';
			exit();
		}
	}
	public static function setHistory($desc){
		$time = date('H:i');
		$data = date("Y-m-d");
		$parametros = array(
			"configuracoes" => array("tabela" => 10, "operacao" => 1),
			"valores" => array("desc" => $desc, "data" => $data, "hora" => $time)
		);
		$db = new database($parametros);
	}
	public function url_get_contents ($Url) {
		if (!function_exists('curl_init')){
			die('CURL is not installed!');
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FILETIME, true);
		$output = curl_exec($ch);
		return $output;
	}
}
?>
