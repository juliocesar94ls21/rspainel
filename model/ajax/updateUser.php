<?php
session_start();
require_once("../../database/database.php");

$nome = $_POST["nome"];	
$mail = $_POST["email"];
$pass_new = md5($_POST["pass-new"]);
$pass_actual = $_POST["pass-actual"];
$tel_user =  $_POST["telefone"];

if(md5($pass_actual) != $_SESSION["USER_PASS"]){
	print '<p class="info-error-edtuser"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Senha atual incorreta</p>';
	exit();
}

$post = array(
	"email" => $mail,
	"nome" => $nome,
	"telefone" => $tel_user
);
if($_POST["pass-new"] != ""){
	$post["senha"] = $pass_new;
	$_SESSION["USER_PASS"] = $pass_new;
}

$parametros = array(
	"configuracoes" => array("tabela" => 4, "operacao" => 6), 
	"valores" => $post,									 
	"condicao" => array("campo" => "id", "valor" => $_SESSION["USER_ID"])
);
$db = new database($parametros);

if($db->erro === null){
	$_SESSION["USER_NAME"] = $nome;
	$_SESSION["USER_MAIL"] = $mail;
	$_SESSION["USER_TEL"] = $tel_user;
	print '<p class="info-sucess-edtuser"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>Editado com sucesso</p>';
}else{
	print '<p class="info-error-edtuser"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Falha: '.$db->erro.'</p>';
}
?>