<form method="post" action="{url}" autocomplete="off" id="formCadPedido">
		<div class="row">
					<label>Nome:</label><input type="text" required name="nome" placeholder="Digite o nome do cliente"/>
			</div>
			<br>
			<div class="row">
					<label>Telefone:</label><input type="tel" required name="telefone" placeholder="Digite o telefone do cliente" />
			</div>
			<br>
			<div class="label col-md-1">
					<label>Email:</label><input type="email" name="email" placeholder="Digite o email do cliente"/>
			</div>
			<br>
			<div class="row">
					<label>Cep:</label>
					<input type="text" class="cep" required name="cep" placeholder="Digite o Cep"/>
			</div>
			<div class="label col-md-2">
					<label>Cidade:</label><select class="select-cidade rs-select-default-size" name="cidadeid"></select>
			</div>
			<div class="row">
					<label>Rua:</label><input type="text" class="rua" required name="rua" placeholder="Digite o nome da rua"/>
			</div>
			<div class="label col-md-1">
					<label>Nº:</label><input type="text" class="numero" required name="numero" placeholder="Nº da casa"/>
			</div>
			<div class="row">
					<label>Bairro:</label><input type="text" class="bairro" name="bairro" required placeholder="Digite o nome do bairro" />
			</div>
			<div class="label col-md-2">
					<label>Complemento:</label><input type="text" name="complemento" placeholder="Digite o complemento"/>
			</div>
			<div class="row">
					<label>Observação:</label><input type="text" name="observacao" placeholder="Digite uma observação"/>
			</div>
		<div class="row">
				<label>Referencia:</label><input id="input-rs-rfc" required type="text" name="referencia" placeholder="Digite um código de referência ou clique em Gerar" /><button class="btn-rs-default btn-generate-code">Gerar</button>
		</div>
		<div class="row">
			<div class="label col-md-2">
				<label>Produtos:</label>
			</div>
			<div class="rs-input col-md-10">
				<input class="rs-produto-id" type="text" name="produto" placeholder="Digite o nome do produto"/>
				<div class="sub-itens-product"></div>
			</div>
		</div>
		<input type="hidden" name="idPdts" id="idPdts" />
		<input type="hidden" name="corPdts" id="corPdts" />
		<input type="hidden" name="sizePdts" id="sizePdts" />
		<div class="row">
			<div class="label col-md-2">
				<label>Data de Entrega:</label>
			</div>
			<div class="rs-input col-md-4">
				<input class="rs-date-pedido" required type="text" name="entrega" placeholder="Digite a data de entrega" value="{entrega}"/>
			</div>

			<div class="label col-md-2">
				<label>Pagamento:</label>
			</div>
			<div class="rs-input col-md-4">
				<select class="rs-select-client select-payment" name="pagamento" placeholder="Selecione a forma de pagamento">
					<option value="Débito" {Débito}>Débito<option>
					<option value="Crédito" {Crédito}>Crédito<option>
					<option value="Dinheiro" {Dinheiro}>Dinheiro</option>
				</select>
			</div>
			<div class="label col-md-3">
				<label class="select-type-payment">Como predente receber:</label>
			</div>
			<div class="rs-input col-md-4 select-type-payment">
				<select class="rs-select-client" name="tipoparcela">
					<option value="2" {credito-2}>Na hora<option>
					<option value="3" {credito-3}>Em 14 dias<option>
					<option value="4" {credito-4}>Em 30 dias</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="label col-md-2">
				<label>Observação:</label>
			</div>
			<div class="rs-input col-md-10">
				<input type="text" name="obs" placeholder="Digite uma observação caso haja" value="{obs}"/>
			</div>
		</div>
		<div class="row">
			<div class="label col-md-2">
				<label>Taxas:</label>
			</div>
			<div class="rs-input col-md-10">
				<select class="rs-select-taxa" multiple name="taxas[]" placeholder="selecione uma taxa">
					{optionsTaxa}
				</select>
			</div>
		</div>
		<div class="row">
			<div class="label col-md-2">
				<label>Desconto:</label>
			</div>
			<div class="rs-input col-md-3">
				<select class="rs-select-client" name="descontoTipo" placeholder="Selecione o tipo de impacto no preço">
					<option value="0" {desconto-0}>Porcentagem<option>
					<option value="1" {desconto-1}>Valor Fixo<option>
				</select>
			</div>
			<div class="label col-md-2">
				<label>Valor:</label>
			</div>
			<div class="rs-input col-md-5">
				<input type="text" name="descontoValor" placeholder="Digite o valor do desconto" value="{descontoValor}"/>
			</div>
		</div>
		<input id="rs-input-cliente" name="clienteid" type="hidden" value="{idcl}"/>
		<input name="vendedorid" type="hidden" value="{idvd}"/>
		<input type="hidden" name="img_value" id="img_value" value="" />
		<div class="row">
			<div class="btn-rs-submit col-md-3">
				<input type="submit" value="Cadastrar"/>
			</div>
		</div>
</form>