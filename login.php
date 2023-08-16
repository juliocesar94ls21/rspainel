<?php
require_once("database/database.php");
require_once("config.php");
require_once("model/classes/utilities.php");

session_start();
	if(isset($_SESSION["logado"]) == true) {
		$time = date('h:i');
		$data = date("Y-m-d");
		$desc = $db->recebeRegistros[0]["nome"]." logou ";
		utilities::setHistory($desc,$data,$time);
					
		header("Location: http://".$_SERVER['HTTP_HOST'].BASE_DIR);
		exit;
	}
	$emailCookie = ( isset($_COOKIE["usuarioEmail"]) ) ? $_COOKIE["usuarioEmail"] : "";
	$dataError = "";
	
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$userMail = $_POST["input_user_mail"];
	$userPass = md5($_POST["input_user_pass"]);
	$parametros = array(
		"configuracoes" => array("tabela" => 4, "operacao" => 4), 
		"column" => "all", 
		"clause" => sprintf("email = '%s'",$userMail)
	);
	$db = new database($parametros);
	if($db->erro == null){
		if(count($db->recebeRegistros) == 0){
			$dataError = "Email incorreto";
		}else{
			$parametros = array(
				"configuracoes" => array("tabela" => 4, "operacao" => 4), 
				"column" => "all", 
				"clause" => sprintf("senha = '%s'",$userPass)
			);
			$db = new database($parametros);
			if($db->erro == null){
				if(count($db->recebeRegistros) == 0){
					$dataError = "Senha incorreta";
				}else{
					$parametros = array(
					"configuracoes" => array("tabela" => 4, "operacao" => 4), 
						"column" => "all", 
						"clause" => sprintf("email = '%s' and senha = '%s'",$userMail,$userPass)
					);
					$db = new database($parametros);
					$_SESSION["logado"] = true;
					$_SESSION["USER_NAME"] = $db->recebeRegistros[0]["nome"];
					$_SESSION["USER_TYPE"] = $db->recebeRegistros[0]["type"];
					$_SESSION["USER_ID"] = $db->recebeRegistros[0]["id"];
					$_SESSION["USER_MAIL"] = $db->recebeRegistros[0]["email"];
					$_SESSION["USER_TEL"] = $db->recebeRegistros[0]["telefone"];
					$_SESSION["USER_PASS"] = $db->recebeRegistros[0]["senha"];
					
					$desc = $db->recebeRegistros[0]["nome"]." logou ";
					utilities::setHistory($desc);
					
					setcookie('usuarioEmail', $userMail, strtotime('+30days'));
					header("Location: http://".$_SERVER['HTTP_HOST'].BASE_DIR);
					exit;
				}
			}else{
				unset($_SESSION["logado"]);
				$dataError = "Falha na operação: ".$db->erro;
			}
		}
	}else{
		$dataError = "Falha na operação: ".$db->erro;
	}	
}
?>
<html>
<head>
<title>RSMarcenaria Administração</title>
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link href="bootstrap-3.3.7-dist\css\bootstrap.min.css" rel="stylesheet">
<link href="jquery-ui-1.12.1.custom\jquery-ui.css" rel="stylesheet">
<link href="css/login.css?<?php print SYSTEM_VERSAO ?>" rel="stylesheet"/>
<script src="jquery-ui-1.12.1.custom\external\jquery\jquery.js"></script>
<script src="bootstrap-3.3.7-dist\js\bootstrap.min.js"></script>
<script src="jquery-ui-1.12.1.custom\jquery-ui.js"></script>
<script src="js\global.js?<?php print SYSTEM_VERSAO ?>"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div class="container content-lg">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" autocomplete="off">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" name="input_user_mail" id="inputEmail" value="<?php echo $emailCookie; ?>" class="form-control" placeholder="Endereço de email" required autofocus>
                <input type="password" name="input_user_pass" id="inputPassword" class="form-control" placeholder="Senha" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" name="input_log_cookies" value="remember-me"> Lembrar
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Entrar</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                esqueceu a senha ?
            </a>
			<p class="login-error"><?php print $dataError ?></p>
        </div><!-- /card-container -->
    </div>
	
<div class="card2 card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" autocomplete="off">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" name="input_user_mail" id="inputEmail" value="<?php echo $emailCookie; ?>" class="form-control" placeholder="Endereço de email" required autofocus>
                <input type="password" name="input_user_pass" id="inputPassword" class="form-control" placeholder="Senha" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" name="input_log_cookies" value="remember-me"> Lembrar
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Entrar</button>
            </form><!-- /form -->
            <a href="#" class="forgot-password">
                esqueceu a senha ?
            </a>
			<p class="login-error"><?php print $dataError ?></p>
        </div><!-- /card-container -->
    </div>	
</body>
</html>