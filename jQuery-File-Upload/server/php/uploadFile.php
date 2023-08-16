<?php

function insertImageDB($foto){
	$id = (int)$_GET["idPdt"];
	$post = array("	imagem" => $foto, "idproduto" => $id);
	$parametros = array(
		"configuracoes" => array("tabela" => 8, "operacao" => 1),
		"valores" => $post 
	);
}
function getFotos(){
	$fotos = array();
	$conn = mysqli_connect("localhost","root","","rspainel");
	$query = "SELECT imagem FROM rs_z_produtos_imagens;";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_assoc($result)){
		array_push($fotos,$row["imagem"]);
	}
	return $fotos;
}

?>