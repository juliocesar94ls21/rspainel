<?php
$options = "";
$optionsTx = "";

$parametrosp = array(
	"configuracoes" => array("tabela" => 2, "operacao" => 4), // tabela é o indice da tabela por ordem alfabetica, operação é 1 para cadastro, 2 para atualização, 3 para remoção (tabela deve possuir campo adicional DISPLAY), 4 para seleção;
	"column" => "id,nome" //coluna no caso de seleção.
);
$dbp = new database($parametrosp);

$count = 0;
foreach($dbp->recebeRegistros as $option){
	$count+= 1;
	$options.= '<option value="'.$option["id"].'">'.$option["nome"].'</option>';
}

$parametrosp = array(
	"configuracoes" => array("tabela" => 6, "operacao" => 4), // tabela é o indice da tabela por ordem alfabetica, operação é 1 para cadastro, 2 para atualização, 3 para remoção (tabela deve possuir campo adicional DISPLAY), 4 para seleção;
	"column" => "id,nome", //coluna no caso de seleção.
	"clause" => "id > 4 and aplicacao = 1"
);
$dbp = new database($parametrosp);

$count = 0;
foreach($dbp->recebeRegistros as $option){
	$count+= 1;
	$optionsTx.= '<option value="'.$option["id"].'">'.$option["nome"].'</option>';
}

?>