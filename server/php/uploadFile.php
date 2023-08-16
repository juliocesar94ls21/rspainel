<?php
require_once("../../config.php");
if(!isset($_SESSION))
    session_start();

function getFotos(){
	$idPdt = $_SESSION["idPdt"];
	$fotos = array();
	$conn = mysqli_connect(HOST,USER,PASS,BANCO);
	$query = "SELECT imagem FROM rs_z_produtos_imagens where idproduto = '$idPdt'";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_assoc($result)){
		array_push($fotos,$row["imagem"]);
	}
	return $fotos;
}

function insertFotos($foto){
	$idPdt = $_SESSION["idPdt"];
	$conn = mysqli_connect(HOST,USER,PASS,BANCO);
	$query = "INSERT INTO rs_z_produtos_imagens(imagem,idproduto) VALUES('$foto','$idPdt')";
	$result = mysqli_query($conn,$query);
}

function deleteFotos($foto){
	$idPdt = $_SESSION["idPdt"];
	$conn = mysqli_connect(HOST,USER,PASS,BANCO);
	$query = "delete from rs_z_produtos_imagens where imagem = '$foto' and idproduto = '$idPdt'";
	$result = mysqli_query($conn,$query);
}

?>