<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastro de Pedidos
			{icon-tools-action}
		</p>
	</div>
	<div class="content-forms">
	<form method="post" action="{url}" autocomplete="off" id="formCadPedido">
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
				<label>Cliente:</label>
			</div>
			<div class="rs-input col-md-10">
				<input class="rs-client-id" required type="text" name="clienteName" placeholder="Digite o nome do cliente" value="{cliente}"/>
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
			<div class="rs-input col-md-10">
				<input class="rs-date-pedido" required type="text" name="entrega" placeholder="Digite a data de entrega" value="{entrega}"/>
			</div>
		</div>
		<div class="row">
			<div class="label col-md-2">
				<label>Pagamento:</label>
			</div>
			<div class="rs-input col-md-3">
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
		$( ".sidebar" ).accordion("option", "active", 2);
	});
		$( ".rs-client-id" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
	        $.ajax({
	            url: "model/autoCompleteClientes.php",
	            dataType: "json",
	            data: {
	                nome: $('.rs-client-id').val()
	            },
	            success: function(data) {
	               response(data);
	            }
	        });
	    },
		focus: function( event, ui ) {
	        $(".rs-client-id").val( ui.item.nome );
	        $("#rs-input-cliente").val(ui.item.id);
	        return false;
	    },
	    select: function( event, ui ) {
	        $(".rs-client-id").val( ui.item.nome );
			$("#rs-input-cliente").val(ui.item.id);
	        return false;
	    }
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
		var htmlElement = item.negativado == 1 ? "<a><b>Cliente negativado: </b><span style='text-decoration:line-through;'>" + item.nome + "</span><span style='float:right;font-weight:bold;font-size:12px;margin-right:10px;margin-top:2px;'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span> Bloqueado</span></a>" : "<a><b>Cliente: </b>" + item.nome + "</a>";
		var classe = item.negativado == 1 ? "ui-state-disabled clt_negativado" : "newclass"; 
      return $( "<li class='"+classe+"'>" )
        .append( htmlElement )
        .appendTo( ul );
    };
	
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
</script>