<?php 
session_start();
 
try {
	$conn = new PDO('mysql:host=rspainel.mysql.uhserver.com;dbname=rspainel', "rsmarcenar", "3b59Rt6G@");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$clause_user = $_SESSION["USER_TYPE"] != 1 ? "and pedidos.vendedorid = ".$_SESSION["USER_ID"] : "";
	$query = "SELECT pedidos.*, clientes.nome, rs_usuarios.nome AS vnome FROM pedidos INNER JOIN clientes ON pedidos.clienteid = clientes.id INNER JOIN rs_usuarios ON rs_usuarios.id = pedidos.vendedorid where pedidos.entregue = 0 and pedidos.pronto = 0 and clientes.negativado = 0 ".$clause_user." ORDER BY entrega ASC";
    $data = $conn->query($query);
 
    foreach($data as $row) {
        print_r($row); 
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
/*$con = mysqli_connect("admin.mysql.uhserver.com","rsmarcenar","root","");
$con = mysqli_connect("admin.mysql.uhserver.com","rsmarcenar","","rspainel");
if(mysqli_connect_errno($con)){
	print mysqli_connect_error($con);
}else{
	print "conectado com sucesso";
}*/
?>