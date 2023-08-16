$(document).ready(function(){
	$(".rs-table thead tr th:last-child,.rs-table thead tr th:first-child,.rs-table tbody tr td:last-child,.rs-table tbody tr td:first-child").css("display","none");
	
	if($(window).outerWidth() < 500){
		$(".card2").css("width", "100%");
	}
	
	$(".btn-generate-code").on("click",function(event ){
		event.preventDefault();
		var alfabeto = ["A","B","C","D","E","F","G","H","I","J","L","M","N","O","P","Q","R","S","T","U","V","X","W","K","Y","Z"];
		var code = "";
		for(i = 0; i < 10; i++){
			var randomLetra = Math.floor(Math.random() * 25);
			code+= alfabeto[randomLetra];
		}
		$("#input-rs-rfc").val(code);
		$("#input-rs-rfc").focus();
	});
	//adiciona R$ aos itens de preço
	var indexEnd,indexObs,indexCpl,indexCor,indexClt,indexRfc,indexPdts,indexNome,indexEmail;
	$(".rs-table thead tr th").each(function(){
		if($(this).children(".th-inner").text() == "preco" || $(this).children(".th-inner").text() == "custo" || $(this).children(".th-inner").text() == "total"){
			var indexTb = $(this).index();
			$(".rs-table tbody tr").each(function(){
				var txt = $(this).children("td").eq(indexTb).text();
				if(txt.indexOf("R$") == -1){
					$(this).children("td").eq(indexTb).html("<b>R$</b>: " + txt);
				}
			});
		}
		if($(this).children(".th-inner").text() == "endereço"){
			indexEnd = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "complemento"){
			indexCpl = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "cor"){
			indexCor = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "cliente"){
			indexClt = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "referencia"){
			indexRfc = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "nome"){
			indexNome = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "email"){
			indexEmail = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "observacao" || $(this).children(".th-inner").text() == "observação"){
			indexObs = $(this).index();
			
		}
		if($(this).children(".th-inner").text() == "produtos" || $(this).children(".th-inner").text() == "produtos"){
			indexPdts = $(this).index();
			
		}
	});
	$(".form-control").on('change focus keydown keyup', upgradeTb);
	upgradeTb();
	function upgradeTb(){
		$(".rs-table tbody tr").each(function(){
			$(this).children("td").each(function(){
				if($(this).text() == "" && !$(this).hasClass("tb-icon") && !$(this).hasClass("tb-block")){
					$(this).text("Sem dados")
				}
				if($(this).index() == indexEnd){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 15){
						var txt = $(this).text().slice(0,15)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexObs){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 15){
						var txt = $(this).text().slice(0,12)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexCpl){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 15){
						var txt = $(this).text().slice(0,8)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexCor){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 10){
						var txt = $(this).text().slice(0,7)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexClt){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 10){
						var txt = $(this).text().slice(0,10)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexRfc){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 5){
						var txt = $(this).text().slice(0,5)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexNome){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 10){
						var txt = $(this).text().slice(0,10)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexEmail){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 15){
						var txt = $(this).text().slice(0,15)+"...";
						$(this).text(txt);
					}
				}
				if($(this).index() == indexPdts){
					var sizeEnd = $(this).text().length;
					if(sizeEnd > 10){
						var txt = $(this).text().slice(0,12)+"...";
						$(this).text(txt);
					}
				}
			});
		});
	}
	$(".print-btn,.btn-print-tb").click(function(){
		window.print();
	});
	$(".acord-up").click(function(event){
		event.preventDefault();
		var elemente = $(this);
		var txt = elemente.text();
		elemente.html("<input type='text' class='rs-input-mn' placeholder='Digite o ID e pressione Enter'/>");
		$(".rs-input-mn").focus();
		$(".rs-input-mn").focusout(function(){
			elemente.text(txt);
		});
		$(".rs-input-mn").keypress(function(e){
			if(e.wich == 13 || e.keyCode == 13){
				window.location.replace($(this).parent("p").attr("data-url")+$(this).val());
			}
		})
	});
	$(".acord-dl").click(function(event){
		event.preventDefault();
		var elemente = $(this);
		var txt = elemente.text();
		elemente.html("<input type='text' class='rs-input-mn-del' placeholder='Digite o ID e pressione Enter'/>");
		$(".rs-input-mn-del").focus();
		$(".rs-input-mn-del").focusout(function(){
			elemente.text(txt);
		});
		$(".rs-input-mn-del").keypress(function(e){	
				if(e.wich == 13 || e.keyCode == 13){
					$("#id-del").val($(this).val());
					$("#tb-del").val($(this).parent("p").attr("data-tb"));
					$("#form-del").attr("action",$(this).parent("p").attr("data-url"));
					$( ".dialog-del" ).dialog( "option", "position", { my: "left", at: "top", of: $(this) } );
					$(".dialog-del").dialog("open");
				}
		});
	});
	$(".forgot-password").click(function(){
		$(this).html('A senha foi salva no Log do servidor <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>');
	});
	$(".data-gasto input").change(function(){
		var date = $(this).val().split("/");
		date.reverse();
		$("#data-gasto").val(date.join("-"));
	});
	$(".rs-input-fncr").change(function(){
		$("#fncr-status").submit();
	});
	function animate(){
		$(".td-aviso-hj").animate({
			'background-color': '#fff',
			color: '#252525'
		},2000, function(){
             $(".td-aviso-hj").animate({
				'background-color': '#8c8c8c',
				color: '#fff'
			},2000, function(){
				 animate();
		   });
       });
	}
	animate();
	function animateRow(){
		$(".row-aviso-hj").animate({
			'background-color': '#adadad',
			color: '#252525'
		},2000, function(){
             $(".row-aviso-hj").animate({
				'background-color': '#fff',
				color: '#000'
			},2000, function(){
				 animateRow();
		   });
       });
	}
	animateRow();

	$('.rs-table').on('click-cell.bs.table', onClickCell);
	
	function onClickCell(event, field, value, row, $element) {
		  if($element.attr("title") == 'Deletar'){
				$("#id-del").val($element.siblings().eq(0).text());
				$( ".dialog-del" ).dialog( "option", "position", { my: "left", at: "top", of: $element } );
				$(".dialog-del").dialog("open");
		  }
		  if($element.attr("class") == 'negative'){
				var idClient = $element.siblings().eq(0).text();
				var index = $element.parents("tr").index();
				spc(idClient,1,index);
		  }
		  if($element.hasClass('reativar')){
				var idClient = $element.siblings().eq(0).text();
				var index = $element.parents("tr").index();
				spc(idClient,0,index);
		  }
	}
	$('.rs-table').on('all.bs.table', animate).on('all.bs.table', animateRow);
	$('.rs-table').on('toggle.bs.table', setDisplayTd);
	$('.rs-table').on('column-switch.bs.table', setDisplayTd);
	$('.rs-table').on('column-switch.bs.table', upgradeTb);
	$('.rs-table').on('page-change.bs.table', upgradeTb);
	$('.rs-table').on('refresh.bs.table', upgradeTb);
	//$('.rs-table').on('all.bs.table', setMenuContext);
	setMenuContext();
	
	function setDisplayTd(){
		$(".rs-table thead tr th:last-child,.rs-table thead tr th:first-child,.rs-table tbody tr td:last-child,.rs-table tbody tr td:first-child").css("display","none");
	}
	$(".rs-select-client option").each(function(){
		if($(this).val() == ""){
			$(this).remove();
		}
	});
	$(".checkbox-vtaxa").change(function(){
		if($(this).prop('checked')){
			$("#idAplcTaxa").val(1);
		}else{
			$("#idAplcTaxa").val(0);
		}
	});
	if($(".checkbox-vtaxa").prop('checked')){
		$("#idAplcTaxa").val(1);
	}else{
		$("#idAplcTaxa").val(0);
	}
	
	$(".value-number").parents("form").submit(function(event){
		$(".value-number").val($(".value-number").val().replace(",","."));
	});
	
	$(".select-payment").on("selectmenuchange", function(event, ui){
		if($(this).val() == "Crédito"){
			$(".select-type-payment").fadeIn("fast");
		}else{
			$(".select-type-payment").fadeOut("fast");
		}
	});
	if($(".select-payment").val() == "Crédito"){
		$(".select-type-payment").fadeIn("fast");
	}else{
		$(".select-type-payment").fadeOut("fast");
	}
	$(".fixed-back-galery, .back-btn").click(function(){
		javascript:window.history.go(-1);
	});
	$("input[type=tel]").mask("(00) 90000-0000");
	$(".price").mask('000.000.000.000.000,00', {reverse: true});
	
	$(".valid-ganhos").click(function(){
		$(".pass-ganhos").fadeIn("slow");
		$(".container-txt-ganhos").fadeIn("slow");
		$(".container-txt-ganhos input").focus();
		$(this).hide();
	});
	$(".container-txt-ganhos input").focusout(function(){
		$(".valid-ganhos").show();
		$(".pass-ganhos").hide();
	});
	$(".icon-eye-ganhos").click(function(){
		$(".valid-ganhos").show();
		$(".pass-ganhos").hide();
	});
	$(".pass-ganhos input").keypress(function(e){	
		if(e.wich == 13 || e.keyCode == 13){
			checkUserPass($(this).val());
			$(this).val("");
		}
	});
	$(".close-ganhos").click(function(){
		checkUserPass();
		$(".txt-ganhos").show();
		$(".content-ganhos").hide();
	});
	//setSaldoMP();
	
	$("#value-taxa, .price").change(function(){
		$(this).val($(this).val().replaceAll(".",""));
		$(this).val($(this).val().replace(",","."));
	});
	$(".content-loader").center();
	
	$("form").submit(function(){
		$(".content-loader").fadeIn();
	});
	$(".load-gig").click(function(){
		$(".content-loader").fadeIn();
	});
	$(".load-gig").keydown(function(){
		$(".content-loader").hide();
	});
	
	$(".menu-galeria").click(function(){
		window.location.replace($(this).attr("data-url"));
	});
	
	$("#formCadPedido").submit(function(event){
		var indexVrg = 0;
		$(".sub-itens-product .row-itens").each(function(){
			var virgula = indexVrg > 0 ? "," : "";
			var barraSize = indexVrg > 0 ? "/" : "";
			var idpdt = virgula + $(this).children("#id_pdt_sub").val();
			var corPdt = virgula + $(this).children(".col-md-3").eq(1).children("input").val();
			var tamanPdt = barraSize + $(this).children(".col-md-3").eq(2).children("input").val();
			$("#idPdts").val($("#idPdts").val() + idpdt);
			$("#corPdts").val($("#corPdts").val() + corPdt);
			$("#sizePdts").val($("#sizePdts").val() + tamanPdt);
			indexVrg+= 1;
		});
	});
	$(".remove-item-pdt").click(function(){
		$(this).parents(".row-itens").remove();
	});
	$("#formCadPedido").submit(function(e){
		if($(".sub-itens-product .row-itens").length == 0){
			e.preventDefault();
			alert("Selecione um produto previamente cadastrado");
			$(".content-loader").hide();
		}
	});
	$(".user-info").mouseenter(function(){
		$(".sub-menu-edit-user").slideDown();
		$(this).addClass("active_bnt_user");
	});
	$(".sub-menu-edit-user, .nav").mouseleave(function(){
		$(".sub-menu-edit-user").slideUp();
		$(".user-info").removeClass("active_bnt_user");
	});
	$(".logout-top").mouseenter(function(){
		$(".sub-menu-edit-user").slideUp();
		$(".user-info").removeClass("active_bnt_user");
	});
	$("#form-edit-user").submit(function(e){
		e.preventDefault();
		$(".content-loader").css("display","none");
		$.ajax({
			url : $(".pass-ganhos").attr("data-url-ajax") + "/model/ajax/updateUser.php",
			data : $(this).serialize(),
			type: "post",
			error: function(jqXHR, textStatus, msg) {
				alert("Falha na requisição ajax (edição de usuário)");
			},
			success: function(data){
				$(".apend-result").html(data).fadeIn("slow");
				setTimeout(function(){ $(".apend-result").fadeOut("slow",function(){$("#pass_user").val("")}); }, 1000);
			}
		});
	});
	$(".btn_generate_pass").on("click",function(event ){
		event.preventDefault();
		var nameUser = $("#name_user_cad").val();
		var code = "";
		for(i = 0; i < 4; i++){
			var randomNumber = Math.floor(Math.random() * 9);
			code+= randomNumber;
		}
		var pass = nameUser != "" ? nameUser.slice(0,3) + code : "user" + code;
		$("#pass_cad_user").val(pass);
		$("#pass_cad_user").focus();
	});
	
	var positions = $(".user-info").offset();
	$(".sub-menu-edit-user").css({"left" : positions.left, "top" : $(".nav").outerHeight()})
	
	$("#action_pronto").click(function(){
		$(this).text("Aguarde...");
		idPedido = $(".row_active_menu").children("td").eq(0).text();
		updatePronto(idPedido);
	});
	$("#action_fazendo").click(function(){
		$(this).text("Aguarde...");
		idPedido = $(".row_active_menu").children("td").eq(0).text();
		updateFazendo(idPedido);
	});
	$("#action_recibo").click(function(){
		idPedido = $(".row_active_menu").children("td").eq(0).text();
		//location.replace($(".pass-ganhos").attr("data-url-ajax")+"recibo/?id="+idPedido);
		window.open($(".pass-ganhos").attr("data-url-ajax")+"recibo/?id="+idPedido,'_blank');
	});
	//searchPddEmAdmt();
	
	$(window).scroll(function(){
		var scrollInit = 190;
		if($("body").scrollTop() > scrollInit){
			$(".rs-footer-content").fadeIn();
		}else{
			$(".rs-footer-content").fadeOut();
		}
	});
	$('.cep').mask('00000-000');
	$(".cep").keyup(function(){
		if($(this).val().length == 9){
			$(".content-loader").fadeIn();
			var cep = $(this).val().replace("-","");
			$.ajax({
				url : "https://viacep.com.br/ws/"+cep+"/json/",
				type: "post",
				dataType: "json",
				error: function(jqXHR, textStatus, msg) {
					$(".content-loader").fadeOut();
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
	$(".rua, .ruaRpd").on("change", searchAdress);
	$(".select-cidade").on( "selectmenuchange", searchAdress);
	$(".numero").mask("0#");
	
});	