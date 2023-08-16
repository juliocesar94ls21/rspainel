<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastrar Taxas</p>
	</div>
	<div class="content-forms">
		<form method="post" action="{url}" autocomplete="off">
			<div class="row">
				<div class="label col-md-2">
					<label>Nome:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" name="nome" placeholder="Digite um nome para identifica-la" value="{nome}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Descrição:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" name="descricao" placeholder="Digite uma taxa, ex: taxa de entrega, taxa de operadora de cartão, etc" value="{descricao}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Valor:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" id="value-taxa" class="price" class="value-number" name="valor" placeholder="Digite o valor da Taxa" value="{valor}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Tipo de Valor:</label>
				</div>
				<div class="rs-input col-md-3">
					<select class="rs-select-client" name="tipo" placeholder="Selecione o tipo de impacto no preço">
						<option value="0" {0}>Porcentagem<option>
						<option value="1" {1}>Valor Fixo<option>
					</select>
				</div>
				<div class="label col-md-2">
					<label>Aplicado ao cliente ?:</label>
				</div>
				<div class="rs-input col-md-2">
					<input type="checkbox" class="checkbox-default checkbox-vtaxa" {checked-1} value="client">
					<input type="hidden" name="aplicacao" id="idAplcTaxa" value="{valueAplTaxa}">
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
		$( ".sidebar" ).accordion("option", "active", 4);
	})
</script>