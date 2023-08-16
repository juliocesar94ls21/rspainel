<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastro Rápido</p>
	</div>
	<div class="content-forms">
	<form method="post" action="{url}" autocomplete="off" id="formCadPedido">
		<div class="row">
				<div class="label col-md-2">
					<label>Nome:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" required name="nome" placeholder="Digite o nome do cliente" value="{nome}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Telefone:</label>
				</div>
				<div class="rs-input col-md-4">
					<input type="tel" required name="telefone" placeholder="Digite o telefone do cliente" value="{telefone}" />
				</div>
				<div class="label col-md-1">
					<label>Email:</label>
				</div>
				<div class="rs-input col-md-5">
					<input type="email" name="email" placeholder="Digite o email do cliente" value="{email}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Cep:</label>
				</div>
				<div class="rs-input col-md-3">
					<input type="text" class="cep" name="cep" placeholder="Digite o Cep" value="{cep}"/>
				</div>
				<div class="label col-md-2">
					<label>Cidade:</label>
				</div>
				<div class="rs-input col-md-3">
					<select class="select-cidade rs-select-default-size" name="cidadeid">
						{optionsCdd}
					</select>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Rua:</label>
				</div>
				<div class="rs-input col-md-7">
					<input type="text" class="rua" required name="rua" placeholder="Digite o nome da rua" value="{rua}"/>
				</div>
				<div class="label col-md-1">
					<label>Nº:</label>
				</div>
				<div class="rs-input col-md-2">
					<input type="text" class="numero" required name="numero" placeholder="Nº da casa" value="{numero}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Bairro:</label>
				</div>
				<div class="rs-input col-md-4">
					<input type="text" class="bairro" name="bairro" placeholder="Digite o nome do bairro" value="{bairro}"/>
				</div>
				<div class="label col-md-2">
					<label>Complemento:</label>
				</div>
				<div class="rs-input col-md-4">
					<input type="text" name="complemento" placeholder="Digite o complemento" value="{complemento}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Observação:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" name="observacao" placeholder="Digite uma observação" value="{observacao}"/>
				</div>
			</div>
		<div class="row">
			<div class="label col-md-2">
				<label>Referencia:</label>
			</div>
			<div class="rs-input col-md-8">
				<input id="input-rs-rfc" required type="text" name="referencia" placeholder="Digite um código de referência ou clique em Gerar" value="{referencia}"/>
			</div>
			<div class="rs-input col-md-2">
				<button class="btn-rs-default btn-generate-code">Gerar</button>
			</div>
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
		$(".select-cidade").select2({placeholder: "Selecione a cidade"});
		$( ".sidebar" ).accordion("option", "active", 2);
		
		$(".cep").keyup(function(){
		if($(this).val().length == 9){
			$(".content-loader").fadeIn();
			var cep = $(this).val().replace("-","");
			$.ajax({
				url : "https://viacep.com.br/ws/"+cep+"/json/",
				type: "get",
				dataType: "json",
				error: function(jqXHR, textStatus, msg) {
					$(".content-loader").fadeOut();
					alert("Falha ao carregar Cep");
				},
				success: function(data){
					$(".rua").val(data.logradouro);
					$(".bairro").val(data.bairro);
					$(".select-cidade option").each(function(){
						if($(this).text() == data.localidade){
							$(this).attr("selected","selected");
							$( ".select-cidade" ).select2();
						}
						$(".numero").focus();
						$(".content-loader").fadeOut();
					});
				}
			})
		}
	});
	});
	
	$( ".rs-produto-id" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
	        $.ajax({
	            url: "model/autoCompleteProdutos.php",
	            dataType: "json",
	            data: {
	                nome: $('.rs-produto-id').val()
	            },
	            success: function(data) {
	               response(data);
	            }
	        });
	    },
		focus: function( event, ui ) {
			$(".rs-produto-id").val( ui.item.nome );
	        return false;
	    },
	    select: function( event, ui ) {
			var html = '<div class="row-itens" style="display:none"><input type="hidden" id="id_pdt_sub" value="'+ui.item.id+'"><div class="col-md-1"><span>Produto: </span></div><div class="col-md-3"><input type="text" disabled value="'+ ui.item.nome +'"></div><div class="col-md-1"><span>Cor: </span></div><div class="col-md-3"><input type="text" required placeholder="Digite a Cor"></div><div class="col-md-1"><span>Tamanho: </span></div><div class="col-md-3"><input class="no-border" required type="text" value="'+ ui.item.tamanho +'"></div><div class="remove-item-pdt"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></div></div>';
			$(".sub-itens-product").append(html);
			$(".rs-produto-id").val("");
			$(".row-itens:last-child").fadeIn("fast");
			$(".remove-item-pdt").click(function(){
				$(this).parents(".row-itens").fadeOut( "fast", function() {
					$(this).remove();
				});
			});
	        return false;
	    }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a><b>Produto: </b>" + item.nome + "</a>" )
        .appendTo( ul );
    };
	
	$(".rua").autocomplete({
		minLength: 3,
		source: function( request, response ) {
	        $.ajax({
	            url: "https://viacep.com.br/ws/PR/"+$(".select-cidade option:selected").text()+"/"+$(".rua").val()+"/json/",
	            dataType: "json",
	            success: function(data) {
	               response(data);
	            }
	        });
	    },
		/*focus: function( event, ui ) {
			$(".rs-produto-id").val( ui.item.nome );
	        return false;
	    },*/
	    select: function( event, ui ) {
			$(".rua").val(ui.item.logradouro);
			$(".bairro").val(ui.item.bairro);
			$(".cep").val(ui.item.cep);
			$(".numero").focus();
	        return false;
	    }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a><b>" + item.logradouro + "</b>, " + item.localidade + "/" + item.uf + ", " + item.bairro +"</a>" )
        .appendTo( ul );
    };
	
</script>