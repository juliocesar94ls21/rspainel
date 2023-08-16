<?php
define("SYSTEM_VERSAO","v6.474");
define("BASE_DIR", "/rspainel/");
define("HOST","localhost");
define("PASS","3b59Rt6G@");
define("USER","root");
define("BANCO","rspainel");
define("CLIENTE_ID","7177545623645389");
define("CLIENTE_SECRET","yJJN254X8frrb2bS9doBhG6otMDFfq2t");
define("USER_ID","243074611");
define("SMTP_HOST","smtp.rsmarcenaria.com");
define("SMTP_USER","rsmarcenaria@rsmarcenaria.com");
define("SMTP_PASS","99799615kjulio");
define("SMTP_PORT",587);
define("TAXA_COMISSÃO",50);
define("TEMPO_PRODUCAO",10);
date_default_timezone_set('America/Sao_Paulo');
set_time_limit(60);

//-----------------------------------------------
function UrlAtual(){
 $dominio= $_SERVER['HTTP_HOST'];
 $url = "http://" . $dominio. $_SERVER['REQUEST_URI']."&submit=1";
 return $url;
 }
?>
