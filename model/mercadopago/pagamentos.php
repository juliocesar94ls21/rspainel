<?php
require_once("config.php");
require_once("mercado-pago/lib/mercadopago.php");
require_once("model/classes/utilities.php");

$data = array();
$body = "";
$viewContent = file_get_contents("view/pagamentosmp.tpl");
$header = "<th>Indice</th><th>OrdemID</th><th>Cliente</th><th>Data</th><th>Horário</th><th>Cartão</th><th>Bandeira</th><th>Total</th><th>Recebido</th><th>Estado</th><th>Dsiplay</th>";

$mp = new MP (CLIENTE_ID,CLIENTE_SECRET);

$filters = array (
        "id"=>null,
        "site_id"=>null,
        "external_reference"=>null
    );

$searchResult = $mp->search_payment ($filters);
$valores = array_reverse($searchResult["response"]["results"]);

for($i = 0; $i < count($valores); $i++){
	$body.= "<tr>".
		"<td>".$i.
		"<td title='ID da ordem do Mercado Pago'>".$valores[$i]["collection"]["id"]."</td>".
		"<td title='Corresponde ao nome impresso no cartao usado no pagamento'>".strtolower($valores[$i]["collection"]["cardholder"]["name"])."</td>".
		"<td title='Data em que foi realizado o pagamento'>".utilities::formatDate(substr($valores[$i]["collection"]["date_created"],0,10))."</td>".
		"<td title='Hora em que foi realizado o pagamento'>".substr($valores[$i]["collection"]["date_created"],11,5)."</td>".
		"<td>".utilities::getCard($valores[$i]["collection"]["payment_type"])."</td>".
		"<td>".utilities::getBandeira($valores[$i]["collection"]["payment_method_id"])."</td>".
		"<td title='Total da compra'>"."<b>R$</b> ".str_replace(".",",",$valores[$i]["collection"]["transaction_amount"])."</td>".
		"<td title='Total recebido prelo Mercado Pago'>"."<b>R$</b> ".str_replace(".",",",$valores[$i]["collection"]["net_received_amount"]+0)."</td>".
		"<td>".utilities::getStatus($valores[$i]["collection"]["status"])."</td>".
		"<td>1</td>".
	"</tr>";
}
$content = str_replace(array("{header}","{body}"),array($header,$body),$viewContent);
print $content;
?>