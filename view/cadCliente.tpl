<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastro de Clientes</p>
	</div>
	<div class="content-forms">
		<form method="post" action="{url}" autocomplete="off">
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
			<input id="rs-input-cliente" name="clienteid" type="hidden" value="{vendedorid}"/>
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
		$( ".sidebar" ).accordion("option", "active", 1);
		
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
	$(".select-cidade").select2({placeholder: "Selecione a cidade"});
	});
	
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
</script>