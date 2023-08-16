<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastro de usuário</p>
	</div>
	<div class="content-forms">
		<form method="post" action="{url}" autocomplete="off">
			<div class="row">
				<div class="label col-md-2">
					<label>Nome:</label>
				</div>
				<div class="rs-input col-md-10">
					<input class="ucfisrt" id="name_user_cad" required type="text" name="nome" placeholder="Digite o nome do usuário"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Email:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" required name="email" placeholder="Digite o email do usuario"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Telefone:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="tel" name="tel" placeholder="Digite o numero de telefone do usuário" />
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Senha:</label>
				</div>
				<div class="rs-input col-md-8">
					<input type="text" id="pass_cad_user" required name="senha" placeholder="Digite a senha do usuario ou clique em Gerar" />
				</div>
				<div class="rs-input col-md-2">
					<button class="btn-rs-default btn_generate_pass">Gerar</button>
				</div>
			</div>
			<div class="label col-md-2">
				<label>Tipo de conta:</label>
			</div>
			<div class="rs-input col-md-10">
				<select class="rs-select-client" name="type">
					<option value="2">Vendedor<option>
					<option value="1">Administrador<option>
				</select>
			</div>
			<div class="row">
				<div class="btn-rs-submit col-md-3">
					<input type="submit" value="Cadastrar"/>
				</div>
			</div>
		</form>
	</div>
</div>
<div title="Remover Item" class="dialog-del">
	Tem certeza que vai remover ?
	<form id="form-del" action="{url_del}" method="post">
		<input id="id-del" name="id-del" type="hidden" value=""/>
		<input id="tb-del" name="tb-del" type="hidden" value="{id_del_tb}"/>
	</form>
</div>