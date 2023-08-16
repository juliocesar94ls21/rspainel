<?php
if(isset($_GET["deleteHistory"]) and isset($_POST["tb-del"])){
	$parametros = array(
		"configuracoes" => array("tabela" => 10, "operacao" => 5),
		"condicao" => array("campo" => "1", "valor" => 1)
	);
	$db = new database($parametros);
	
	if($db->erro === null){
		$desc = $_SESSION["USER_NAME"].' <b class="text-delete">Limpou</b> o histórico ';
		utilities::setHistory($desc);
	}
	$dir = "img/screenshot/";
	delDirectoryFiles($dir);
	$dir = "img/paginas/";
	delDirectoryFiles($dir);	

}
function delDirectoryFiles($dir){
	$dir_contents = scandir($dir);
	foreach($dir_contents as $file){
		if(!is_dir($file)){
			unlink($dir.$file);
		}
	}		
}

$body = "";
$header = "<th>ID</th><th>Histórico</th><th>display</th>";
$parametros = array(
	"configuracoes" => array("tabela" => 10, "operacao" => 4),
	"column" => "all",
	"clause" => "1=1 ORDER BY id DESC, data DESC"
);
$db = new database($parametros);
$consulta = $db->recebeRegistros;
$button = '<span title="Limpar histórico" class="glyphicon glyphicon-trash btn-del-story" aria-hidden="true"></span>';
$tableFile = $button.file_get_contents("view/table.tpl");
$dataAtual = date("d/m/Y");
$dataOntem = date("d/m/Y", strtotime( "-1 day" ));

for($i = 0; $i < count($consulta); $i++){
	$data = implode("/",array_reverse(explode("-",$consulta[$i]["data"])));
	$texto = "";
	if($data == $dataAtual){
		$data = "Hoje";
	}
	else if($data == $dataOntem){
		$data = "Ontem";
	}
	else{
		$texto = "em ";
	}
	$body.= "<tr><td>".$consulta[$i]["id"]."</td>
	<td>".$consulta[$i]["desc"].$texto." <b style='font-size:15px;color: #156102;'>".$data."</b> às <b style='font-size:15px;color: #156102;'>".substr($consulta[$i]["hora"],0,5)."</b></td>
	<td>".$consulta[$i]["display"]."</td>";
}
$link = BASE_DIR."?controler=exibeItem&itemIndex=historico&deleteHistory=true";
$content = str_replace(array("{header}","{body}","{indexMenu}","{url_del}","Tem certeza que vai remover ?","Remover Item"),array($header,$body,2,$link,"Deseja limpar o histórico ?","Limpar histórico"),$tableFile);
print $content;
?>
<script>
$(document).ready(function(){	
	$(".btn-del-story").on("click",function(){
		$(".dialog-del").dialog( "option", "position", { my: "left top", at: "right center", of: $(this) } );
		$(".dialog-del").dialog("open");
	});
});
</script>