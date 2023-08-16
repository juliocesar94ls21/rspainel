<?php
require_once("../../config.php");
if(!isset($_SESSION))
    session_start();

$pasta = 'files/';
$args = scandir($pasta);
$images = array();
$extension = array("jpg","png","gif");
for($i = 0; $i < count($args); $i++){
	$file = $pasta.$args[$i];
	if(!is_dir($file) and in_array(substr($args[$i],-3),$extension)){
		$images[] = $args[$i];
	}
}
$idPdt = $_SESSION["idPdt"];
$fotos = array();
$conn = mysqli_connect(HOST,USER,PASS,BANCO);
$query = "SELECT imagem FROM rs_z_produtos_imagens where idproduto = '$idPdt'";
$result = mysqli_query($conn,$query);
while($row = mysqli_fetch_assoc($result)){
	array_push($fotos,$row["imagem"]);
}
foreach($images as $img){
	if(!in_array($img,$fotos)){
		$query = "INSERT INTO rs_z_produtos_imagens(imagem,idproduto) VALUES('$img','$idPdt')";
		$result = mysqli_query($conn,$query);
	}
}
	
?>