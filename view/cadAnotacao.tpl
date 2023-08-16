<div class="rs-whrap-content">	
	<div class="rs-row" style="border-bottom:  1px solid #808080;">
		<p class="rs-tab-title" style="margin-bottom:0;border:none;"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Anotação</p>
	</div>
	<div class="content-forms" style="width:100%;">
		<form method="post" action="{url}" autocomplete="off" id="formCadAnotacao">
			<div style="padding:6px 1px;overflow:hidden;background:#f8f8f8;">	
				<div class="col-md-1"><span style="position:relative;top: 3px;">Título: </span></div>
				<div class="col-md-3"><input class="input-ant" required type="text" name="titulo" value="{titulo}" /></div>
				<div class="col-md-1"><span style="position:relative;top: 3px;">Descrição: </span></div>
				<div class="col-md-6"><input class="input-ant" required type="text" name="descricao" value="{descricao}" /></div>
				<div class="col-md-1"><input title="Publico ?" {checked} class="input-ant-checkbox" type="checkbox" name="acesso" value="{acesso}" /></div>
			</div>
			<textarea name="conteudo" id="editor" rows="50">
				{conteudo}
			</textarea>
			<input name="userid" type="hidden" value="{userid}"/>
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
<script src="ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		CKEDITOR.replace( 'editor' );
		CKEDITOR.config.height = 380;
		CKEDITOR.config.fullPage = true;
	});	
</script>