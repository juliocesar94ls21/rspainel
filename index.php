<?php
session_start();
	require_once("config.php");
	if(!isset($_SESSION["logado"]) and !isset($_GET["putFile"])){
		header("Location: http://".$_SERVER['HTTP_HOST'].BASE_DIR."login.php");
		exit();
	}
	if(!isset($_GET["controler"])){
		header("location:".BASE_DIR."?controler=exibeItem&itemIndex=1");
		exit();
	}
?>
<html>
<head>
<title>RSMarcenaria Administração</title>
<link href="css/global.css?<?php print SYSTEM_VERSAO ?>" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css?family=Raleway|Montserrat:900|Saira+Semi+Condensed" rel="stylesheet">
<link href="bootstrap-3.3.7-dist\css\bootstrap.min.css" rel="stylesheet">
<link href="jquery-ui-1.12.1.custom\jquery-ui.css" rel="stylesheet">
<link href="bootstrap-table-master\src\bootstrap-table.css" rel="stylesheet">
<link href="select2-4.0.3\dist\css\select2.min.css?<?php print SYSTEM_VERSAO ?>" rel="stylesheet">
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<link rel="stylesheet" href="jQuery-File-Upload/css/jquery.fileupload.css">
<link rel="stylesheet" href="jQuery-File-Upload/css/jquery.fileupload-ui.css">
<link rel="stylesheet" href="slider/css/slideshow.css">
<link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<link href="css/override.css?<?php print SYSTEM_VERSAO ?>" rel="stylesheet"/>
<link rel="shortcut icon" type="image/png" href="img/comuns/favicon.png"/>
<script src="jquery-ui-1.12.1.custom\external\jquery\jquery.js"></script>
<script src="bootstrap-3.3.7-dist\js\bootstrap.min.js"></script>
<script src="jquery-ui-1.12.1.custom\jquery-ui.js"></script>
<script src="bootstrap-table-master\src\bootstrap-table.js"></script>
<script src="bootstrap-table-master\src\locale\bootstrap-table-pt-BR.js"></script>
<script src="select2-4.0.3\dist\js\select2.min.js"></script>
<script src="jQuery-Mask\src\jquery.mask.js"></script>
<script src="js\functions.js?<?php print SYSTEM_VERSAO ?>"></script>
<script src="js\global.js?<?php print SYSTEM_VERSAO ?>"></script>
<script src="js\widgets.js?<?php print SYSTEM_VERSAO ?>"></script>
<noscript><link rel="stylesheet" href="jQuery-File-Upload/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css"></noscript>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php 
	require_once("model/statusFinanceiro.php");
	//require_once("model/mercadopago/saldoMP.php");
 ?>
<body id="body">
<div class="nav no-printable">
	<div class="sub-menu-edit-user" style="display:none">
		<p class="title-inf-user"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Alterar meus dados 
			<span style="float:right;<?php if($_SESSION["USER_TYPE"] != 1){print "display:none;";} ?>">
				<a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadUser&indextb=4" title="Cadastrar novo usuário"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>
				<a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=usuarios&view=cadUser&table=0" title="Exibir usuários"><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a>
			</span>
		</p>
		<form action="#" method="post" id="form-edit-user">
			<div class="row">
				<div class="col-md-3">
					<label>Nome: </label>
				</div>
				<div class="col-md-9">
					<input type="text" name="nome" required value="<?php print $_SESSION["USER_NAME"] ?>"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label>Email: </label>
				</div>
				<div class="col-md-9">
					<input type="text" name="email" required value="<?php print $_SESSION["USER_MAIL"] ?>"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label>Telefone: </label>
				</div>
				<div class="col-md-9">
					<input type="tel" name="telefone" value="<?php print $_SESSION["USER_TEL"] ?>"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label>Senha: </label>
				</div>
				<div class="col-md-9">
					<input type="password" name="pass-new" placeholder="digite a nova senha"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label>Senha: </label>
				</div>
				<div class="col-md-9">
					<input type="password" id="pass_user" name="pass-actual" placeholder="digite sua senha atual"/>
				</div>
			</div>
			<div class="row">
				<button class="btn-updtcdt-mini" type="submit">Atualizar</button>
			</div>
			<div class="apend-result" style="display:none">
				<p class="info-sucess-edtuser"></p>
			</div>
		</form>
	</div>
	<span class="title-mail">rsmarcenaria@rsmarcenaria.com</span>
	<a href="<?php print BASE_DIR ?>model/logout.php" class="logout-top load-gig no-printable">Sair</a>
	<a href="#" class="user-info no-printable"><span class="glyphicon glyphicon-chevron-down icon-chevron-down-user" aria-hidden="true"></span><?php print $_SESSION["USER_NAME"] ?></a>
</div>
<div class="rs-container">
	<div class="content-loader" style="display:none">
		<img src="img/three-bar-loader.gif"/>
	</div>
	<div class="container">
		<div class="logo col-md-5">
			<img src="img/comuns/Logo-RsMarcenaria.png" class="img-responsive"/>
		</div>
		<div class="info-item-lcr col-md-7">
			<div class="lcr-content">
				<p class="txt-ganhos" <?php if(!isset($_SESSION["exibeganhos"])){print 'style="display:block"';}else{print 'style="display:none"';} ?>>
					<span class="container-txt-ganhos">
						<span class="glyphicon glyphicon-eye-close icon-eye-ganhos" aria-hidden="true" title="Mostrar"></span>
						<span class="valid-ganhos">Exibir Ganhos</span>
						<span class='pass-ganhos' data-url-ajax="<?php print BASE_DIR ?>"><input type='password' placeholder='Digite a senha' autofocus></span>
						<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> 
					</span>
				</p>
				<p class="content-ganhos" <?php if(isset($_SESSION["exibeganhos"])){print 'style="display:block"';}else{print 'style="display:none"';} ?>>
				<span class='glyphicon glyphicon-eye-open close-ganhos' aria-hidden='true' title="Esconder"></span>
				<a class="str-lucro load-gig" title="Lucro total líquido" href="<?php print BASE_DIR ?>?controler=statusFinancero">
					<span class="glyphicon glyphicon-stats" aria-hidden="true"></span> 
					<span>R$ <?php print $dataLcr ?> </span>
				</a>
				<a class="str-custo load-gig" title="Gasto total" href="<?php print BASE_DIR ?>?controler=statusFinancero">
					<span style="margin-left: 27px;" class="glyphicon glyphicon-stats" aria-hidden="true"></span> 
					<span>R$ <?php print $dataCst ?></span>
				</a>
				<a class="str-mp load-gig" title="Saldo Mercado Pago" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=pagamentos">
					<span style="margin-left: 27px;" class="glyphicon glyphicon-stats" aria-hidden="true"></span> 
					<span>R$ <b>0,00</b></span>
				</a>
				</p>
			</div>
		</div>
	</div>
</div>
<div class="rs-main">
	<div class="col-md-3 rs-menu">
	<?php if($_SESSION["USER_TYPE"] == 1): ?>
		<div class="container-tools-sec">
			<a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=usuarios&view=cadUser&table=0" title="Exibir usuários"><span class='glyphicon glyphicon-user' aria-hidden='true'></span></a>
			<a class="load-gig" title="Status financeiro" href="<?php print BASE_DIR ?>?controler=statusFinancero"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></a>
			<a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=galeria" title="Fotos"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span></a>
			<a class="load-gig" title="Historico" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=historico"><span class="glyphicon glyphicon-header" aria-hidden="true"></span></a>
			<a class="load-gig" title="Pedidos" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=1"><span class='glyphicon glyphicon-align-justify' aria-hidden='true'></span></a>
			<a class="load-gig" title="Clientes" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=0&view=cadCliente&table=0"><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></a>
			<a class="load-gig" title="Anotações" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=anotacoes"><span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></a>
		</div>
	<?php endif ?>
		<div class="sidebar">
			<h3 >PRODUTOS</h3>
			<div class="menu-produtos">
				<?php if($_SESSION["USER_TYPE"] == 1): ?>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadProdutos">Cadastrar Produto</a></p>
				<?php endif ?>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=2&view=cadProdutos&table=2">Exibir Produtos</a></p>
				<?php if($_SESSION["USER_TYPE"] == 1): ?>
				<p data-url="<?php print BASE_DIR ?>?controler=atualizaItem&view=cadProdutos&submit=0&table=2&id=" class="acord-up">Alterar Produto</a></p>
				<p data-url="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=2&view=cadProdutos&table=2&submit=1" data-tb="2" class="acord-dl">Excluir Produto</p>
				<?php endif ?>
			</div>
			<h3 class="menu-clientes">CLIENTES</h3>
			<div id="menu-clientes">
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadCliente&indextb=0">Cadastrar Cliente</a></p>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=0&view=cadCliente&table=0">Exibir Clientes</a></p>
				<p><a class="load-gig nagative_menu" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=negativados">Exibir Clientes Negativados</a></p>
				<?php if($_SESSION["USER_TYPE"] == 1): ?>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadCidade&indextb=9">Cadastrar Cidade</a></p>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=9&view=cadCidade&table=9">Exibir Cidades</a></p>
				<?php endif ?>
				<p data-url="<?php print BASE_DIR ?>?controler=atualizaItem&view=cadCliente&submit=0&table=0&id=" class="acord-up">Alterar Cliente</p>
				<p data-url="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=0&view=cadCliente&table=0&submit=1" data-tb="0" class="acord-dl">Excluir Cliente</p>
			</div>
			<h3 class="menu-pedidos">PEDIDOS</h3>
			<div>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadPedido">Cadastrar Pedido</a></p>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadastroRapido">Cadastrar Rápido</a></p>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=1">Exibir Pedidos</a></p>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=prontaentrega">Pronta Entrega</a></p>
				<p data-url="<?php print BASE_DIR ?>?controler=atualizaItem&view=cadPedido&submit=0&table=1&id=" class="acord-up">Alterar Pedido</p>
				<p data-url="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=1&submit=1" data-tb="1" class="acord-dl">Excluir Pedido</p>
			</div>
			<?php if($_SESSION["USER_TYPE"] == 1){ ?>
			<h3 class="menu-notas">DESPESAS</h3>
			<div>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadGastos&indextb=5">Incluir Despesa</a></p>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=statusFinancero">Exibir Despesas</a></p>
			</div>
			<?php } ?>
			<h3 class="menu-taxas">TAXAS</h3>
			<div>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=cadItem&submit=0&view=cadTaxa&indextb=6">Incluir Taxa</a></p>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=6&view=cadTaxa&table=6">Exibir Taxas</a></p>
				<p data-url="<?php print BASE_DIR ?>?controler=atualizaItem&view=cadTaxa&submit=0&table=6&id=" class="acord-up">Alterar Taxa</p>
				<p data-url="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=6&view=cadTaxa&table=6&submit=1" data-tb="0" class="acord-dl">Excluir Taxa</p>
			</div>
			<h3 class="menu-galeria load-gig" data-url="<?php print BASE_DIR ?>?controler=exibeItem&itemIndex=8">GALERIA</h3>
			<div>
			</div>
			<h3 class="menu-usuarios">LOGOUT</h3>
			<div>
				<p><a class="load-gig" href="<?php print BASE_DIR ?>model/logout.php">Sair</a></p>
			</div>
		</div>
	</div>
	<div class="col-md-9 content" id="content-center">
		<?php
			require_once("controler/controler.php");
		?>
	</div>	
</div>
<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))):
?>
<div class="rs-footer-content no-printable" id="rolar" <?php if(isset($_GET["itemIndex"]) and $_GET["itemIndex"] == 'galeria'){ print "style='display:none'"; } ?>>
	<div class="col-md-3">
		<p><span title="Cliente que mais comprou">Melhor Cliente: </span><span><?php print $clienteMax." (".$maxVendasClt." Compras)"; ?></span></p>
	</div>
	<div class="col-md-3">
		<p><span title="Mais Vendido">Melhor Produto: </span><span><?php print $prodMax." (".$maxVendasProd." Vendas)"; ?></span></p>
	</div>
	<div class="col-md-3">
		<p><span title="Mês em que mais vendeu no ano">Melhor Mês: </span><span><?php print $monthMax." (".$maxVendasMonth." Vendas)"; ?></span></p>
	</div>
	<div class="col-md-3">
		<p><span title="Porcentagem dos lucros sobre as depesas">Margem de Lucro Atual: </span><span><?php print $footerMargemLucro."%"; ?></span></p>
	</div>
</div>
<?php endif ?>
<div class="fixed-message-negativated no-printable">
	<span>Cliente foi negativado</span>
</div>
<div class="fixed-message-reativated no-printable">
	<span>Cliente foi reativado</span>
</div>
<div class="context-menu" style="display:none;">
	<ul class="menu-list-context">
		<li id="action_fazendo">Marcar como "em andamento"</li>
		<li id="action_pronto">Marcar pedido como pronto</li>
		<li id="action_recibo">Gerar recibo do cliente</li>
	</ul>
</div>
<audio id="notificacao" src="img/notificacoes.mp3" type="audio/mpeg" />
<audio id="notificacao2" src="img/notificacoes2.mp3" type="audio/mpeg" />
</body>
</html>