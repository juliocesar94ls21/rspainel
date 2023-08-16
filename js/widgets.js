$( function() {
    $( ".sidebar" ).accordion({heightStyle: "content"});
 });
 
 $(document).ready(function(){
	$(".dialog-info-sucess").dialog({
		maxWidth: 150,
		minWidth: 150,
		autoOpen: true,
		show: { effect: "fade", duration: 800 },
		open: function(){
			$(this).animate({color:"64b74d",},2000,function(){
				$(this).dialog("close");
			})
		}
	});
	$(".dialog-info-error").dialog({
		maxWidth: 150,
		minWidth: 150,
		autoOpen: true,
		show: { effect: "fade", duration: 800 }
	});
	$(".rs-select-client").selectmenu();
	
	$(".rs-date-pedido, .data-gasto input, .rs-input-fncr").datepicker();
	$.datepicker.regional['pt-BR'] = {
		closeText: 'Fechar',
		prevText: '&lt;Anterior',
		nextText: 'Próximo&gt;',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho',
		'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
		'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
	//$(".rs-select-produto").select2({placeholder: "Selecione um produto",language: "pt"});
	$(".rs-select-taxa").select2({placeholder: "Aplicar taxas"});
	
	$(".dialog-del").dialog({
		maxWidth: 150,
		minWidth: 150,
		autoOpen: false,
	buttons: [
			{
				text: "Sim",
				click: function() {
					$("#form-del").submit();
				}
			},
			{
				text: "Não",
				click: function() {
					$( this ).dialog( "close" );
				}
			}
		]
	});
	
	$(".dialog-rcb").dialog({
		maxWidth: 150,
		minWidth: 150,
		autoOpen: true
	});
	
 });