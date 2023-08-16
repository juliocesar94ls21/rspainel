<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastro de Tecido</p>
	</div>
	<div class="content-forms">
		<form method="post" action="{url}" autocomplete="off">
			<div class="row">
				<div class="label col-md-2">
					<label>Tecido:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" required name="nome" placeholder="Digite o nome do tecido" value="{nome}"/>
				</div>
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
<script>
	$(document).ready(function(){
		$( ".sidebar" ).accordion("option", "active", 6);
	});
</script>