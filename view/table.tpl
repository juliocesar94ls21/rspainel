<div class="content-table">
	<table class="rs-table" data-toggle="table" data-search="true" data-show-toggle="true" data-show-columns="true" data-mobile-responsive="true" data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-pagination-switch="true" data-locale="pt-BR">
		<thead>
			{header}
		</thead>
		<tbody>
			{body}
		</tbody>
	</table>
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
		$( ".sidebar" ).accordion("option", "active", {indexMenu});
	})
</script>