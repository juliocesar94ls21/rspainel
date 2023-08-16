<?php
require_once("../config.php");
require_once("../database/database.php");
require_once("classes/utilities.php");
session_start();
$desc = $_SESSION["USER_NAME"].' deslogou';
utilities::setHistory($desc);
unset($_SESSION["logado"]);
header("Location: http://".$_SERVER['HTTP_HOST'].BASE_DIR."login.php");
?>