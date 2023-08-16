<div class="rs-whrap-content">	
	<div class="rs-row">
		<p class="rs-tab-title">Cadastro de Produtos</p>
	</div>
	<div class="content-forms">
		<form method="post" action="{url}" autocomplete="off">
			<div class="row">
				<div class="label col-md-2">
					<label>Nome:</label>
				</div>
				<div class="rs-input col-md-10">
					<input class="ucfisrt" type="text" required name="nome" required placeholder="Digite o nome do produto" value="{nome}"/>
				</div>
			</div>
			<input id="size" name="tamanho" type="hidden" value="{tamanho}"/>
			<div class="row">
				<div class="label col-md-2">
					<label>Tamanho(Altura):</label>
				</div>
				<div class="rs-input col-md-2">
					<input class="rs-size" type="text" name="altura" placeholder="Altura" value=""/>
				</div>
				<div class="label col-md-2">
					<label>Largura:</label>
				</div>
				<div class="rs-input col-md-2">
					<input class="rs-size" type="text" name="largura" placeholder="Largura" value=""/>
				</div>
				<div class="label col-md-2">
					<label>Comprimento:</label>
				</div>
				<div class="rs-input col-md-2">
					<input class="rs-size" type="text" name="comprimento" placeholder="Comprimento" value=""/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Preço:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" required class="price" name="preco" placeholder="Digite o preço do produto" value="{preco}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Custo:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" name="custo" class="price" placeholder="Digite o custo de produção do produto" value="{custo}"/>
				</div>
			</div>
			<div class="row">
				<div class="label col-md-2">
					<label>Observação:</label>
				</div>
				<div class="rs-input col-md-10">
					<input type="text" name="observacao" placeholder="Digite uma observação caso haja" value="{observacao}"/>
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
		$( ".sidebar" ).accordion("option", "active", 0);
		
		var size = $("#size").val();
		var args = size.split("x");
		for(i = 0; i < args.length; i++){
			$(".rs-size").eq(i).val(args[i]);
		}
		$(".rs-size").removeAttr("name");
		
		$(".rs-size").change(function(){
			$("#size").val($(".rs-size").eq(0).val()+"x"+$(".rs-size").eq(1).val()+"x"+$(".rs-size").eq(2).val());
		});
	})
</script>