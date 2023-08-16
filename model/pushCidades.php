<?php
$options = "";

$parametrosc = array(
	"configuracoes" => array("tabela" => 9, "operacao" => 4), // tabela é o indice da tabela por ordem alfabetica, operação é 1 para cadastro, 2 para atualização, 3 para remoção (tabela deve possuir campo adicional DISPLAY), 4 para seleção;
	"column" => "id,nome" //coluna no caso de seleção.
);
$dbc = new database($parametrosc);

$count = 0;
foreach($dbc->recebeRegistros as $option){
	$count+= 1;
	$options.= '<option value="'.$option["id"].'">'.$option["nome"].'</option>';
}

?>