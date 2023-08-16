<?php
/*$conn = mysqli_connect("localhost","root","","rspainel");
					$query = "insert into rs_z_produtos_imagens(id,imagem,idproduto,display) values(0,'nada.jpg',1,0)";
					mysqli_query($conn,$query);
					*/
$pasta = '/img/';
$args = scandir($pasta);
print_r($args);
?>