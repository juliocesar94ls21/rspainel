<?php
require_once("database/database.php");

$viewError = file_get_contents("view/infoError.tpl");
$parametros = array(
	"configuracoes" => array("tabela" => 8, "operacao" => 4),
	"column" => "imagem",
	"clause" => "idproduto = ".$_GET["idPdt"]
);
$db = new database($parametros);
$path = 'server/php/files/';
$extension = array("jpg","png","gif");
$fotos = array();
$files_img = scandir($path);

foreach($files_img as $file){
	if(!is_dir($path.$file) and in_array(substr($file,-3),$extension)){
		$fotos[] = $file;
	}
}

if(count($fotos) > 0){
?>
<div class="fixed-back-galery">
	<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>
</div>
<div id="container-slider">
<div id="slideshow" class="fullscreen">
<?php
$i = 0;
foreach($fotos as $foto){
$i++;
?>
	<!-- Below are the images in the gallery -->
		<div id="img-<?php print $i; ?>" data-img-id="<?php print $i; ?>" class="img-wrapper <?php if($i == 1){ print "active"; } ?>" style="background-image: url('server/php/files/<?php print $foto; ?>')"></div>
<?php } ?>
		<!-- Below are the thumbnails of above images -->
		<div class="thumbs-container bottom">
		<div id="prev-btn" class="prev"> <i class="fa fa-chevron-left fa-3x"></i> </div>
		<ul class="thumbs">
<?php
$i = 0;
foreach($fotos as $foto){
$i++;
?>
			<li data-thumb-id="<?php print $i; ?>" class="thumb <?php if($i == 1){ print "active"; } ?>" style="background-image: url('server/php/files/<?php print $foto; ?>')"></li>
<?php } ?>
			</ul>
		<div id="next-btn" class="next"> <i class="fa fa-chevron-right fa-3x"></i> </div>
		</div>
	</div>
</div>
<script src="slider/js/gallery.js"></script>
<?php 
}else{
	print str_replace("{error}","Nenhum imagem encontrada",$viewError);
}
?>