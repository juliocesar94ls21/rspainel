<div class="rs-whrap-content table-statusfnc">
	<div class="rs-row">
		<p class="rs-tab-title">Relatório Financeiro</p>
	</div>
	<div class="content-forms">
		<form id="fncr-status" method="post" action="" autocomplete="off">
			<div class="row">
				<div class="label col-md-2">
					<label>Filtrar por data: </label>
				</div>
				<div class="label col-md-1">
					<label>de: </label>
				</div>
				<div class="rs-input col-md-3">
					<input type="text" class="rs-input-fncr" name="data-init" placeholder="Selecione a data inicial" value="{data-init}"/>
				</div>
				<div class="rs-input col-md-1">
				</div>
				<div class="label col-md-1">
					<label>a: </label>
				</div>
				<div class="rs-input col-md-3">
					<input type="text" class="rs-input-fncr" name="data-end" placeholder="Selecione a data final" value="{data-end}"/>
				</div>
			</div>
		</form>
	</div>
	<hr class="line-default no-printable"/>
	<div class="fncr-info-tt">
		<div class="col-md-6">
			<p><span>Lucro total neste período: </span><span>R$ {totalLucroMax}</span></p>
		</div>
		<div class="col-md-6">
			<p><span>Despeza total neste período: </span><span>R$ {totalDpMax}</span></p>
		</div>
	</div>
	<hr class="line-default"/>
	<div class="fnc-bootstrap-tb col-md-12">
		<table class="fncr-table">
			<thead>
				<tr><th>Total de vendas</th><th>Lucro das vendas</th><th>Custo de Produção</th></tr>
			</thead>
			<tbody>
				<tr><td>{totalVendas}</td><td>R$ {totalLucro}</td><td>R$ {totalCusto}</td></tr>
			</tbody>
		</table>
		<table class="rs-table" data-toggle="table" data-search="true" data-show-columns="true" data-mobile-responsive="true" data-pagination="true" data-show-pagination-switch="true" data-locale="pt-BR">
			<thead>
				{header}
			</thead>
			<tbody>
				{body}
			</tbody>
		</table>
		<table class="fncr-table">
			<thead>
				<tr><th>Total de itens (despesas)</th><th>Valor total das despesas</th></tr>
			</thead>
			<tbody>
				<tr><td>{totalItens}</td><td>R$ {totalCustoDp}</td></tr>
			</tbody>
		</table>
		<table class="rs-table" data-toggle="table" data-search="true" data-show-columns="true" data-mobile-responsive="true" data-pagination="true" data-show-pagination-switch="true" data-locale="pt-BR">
			<thead>
				{headerTbdp}
			</thead>
			<tbody>
				{bodyTbdp}
			</tbody>
		</table>
	</div>
	<div class="fncr-fotter col-md-12">
		<button title="Imprimir Dados" class="botao-padrao print-btn">Imprimir</button>
	</div>
</div>
<div title="Remover Item" class="dialog-del">
	Tem certeza que vai remover ?
	<form id="form-del" action="{dir}" method="post">
		<input id="id-del" name="id-del" type="hidden" value=""/>
		<input id="tb-del" name="tb-del" type="hidden" value="5"/>
	</form>
</div>