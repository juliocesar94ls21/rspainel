<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastrar Gasto</p>
	</div>
	<div class="content-forms">
		<form method="post" action="{url}" autocomplete="off">
			<div class="row">
				<div class="label col-md-2">
					<label>Gasto:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" name="gasto" placeholder="Digite um gasto, ex: combustível, documentos, imprevistos, etc." value=""/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Custo:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" class="value-number price" name="custo" placeholder="Digite o custo" value=""/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Data:</label>
				</div>
				<div class="rs-input data-gasto col-md-10">
					<input type="text" placeholder="Selecione a data que ocorreu esse gasto" value=""/>
				</div>
			</div>
			<input type="hidden" id="data-gasto" name="data" value=""/>
			<div class="row">
				<div class="label col-md-2">
					<label>Observação:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" name="observacao" placeholder="Digite uma observação caso haja." value=""/>
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
		$( ".sidebar" ).accordion("option", "active", 3);
	})
</script>