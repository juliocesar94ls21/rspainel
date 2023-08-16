function setStringPrice(){
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
	});
}
var checkUserPass = function(parametro = null){
	var dataSend = parametro == null ? 'close' : parametro;
	$.ajax({
		url : $(".pass-ganhos").attr("data-url-ajax") + "/model/checkuserpass.php",
		data : {pass : parametro},
		type: "post",
		dataType: "json",
		error: function(jqXHR, textStatus, msg) {
            alert("Falha ao checkar senha");
        },
		success: function(data){
			if(typeof(data.close) == 'undefined'){
				if(typeof(data.error) == 'undefined'){
					$(".txt-ganhos").hide();
					$(".content-ganhos").fadeIn("slow");
				}
				else{
					$(".container-txt-ganhos").addClass('shadow-pulse');
					$(".container-txt-ganhos").animate({
						'border-color': '#dc0000',
					},500, function(){
						$(".container-txt-ganhos").removeClass('shadow-pulse');
						$(".container-txt-ganhos").css('border-color','#808080');
					});
				}
			}
		}
	});
}
function balomTitle(options){
	var content = '<div class="ballom-title">',
	icon = '<img src="img/comuns/balao.png" />',
	title = typeof(options.title) == "undefined" ? null : options.title,
	positionLeft = typeof(options.positionLeft) == "undefined" ? null : options.positionLeft,
	positionTop = typeof(options.positionTop) == "undefined" ? null : options.positionTop,
	remove = typeof(options.remove) == "undefined" ? false : options.remove;
	//alert(positionLeft);
	if(title != "" && title != null){
		$("body").append(content+"<p>"+title+"</p>"+icon+"</div>");
		$(".ballom-title").css({top: positionTop, left: positionLeft});
	}
	if(remove == true){
		$(".ballom-title").remove();
	}
}
function setSaldoMP(){
	var cont = 0,
	timeEndAnimate = 0,
	time = 1000,
	intervalo = setInterval(getSaldo, time);
	
	function getSaldo(){
		var element = $(".str-mp span:nth-child(2) b");
		var saldoAtual = element.text();
		cont++;
		$.ajax({
			url : $(".pass-ganhos").attr("data-url-ajax") + "/model/mercadopago/saldoMP.php",
			type: "post",
			data : {ajax : true},
			dataType: "json",
			success: function(data){
				if(data.saldo != saldoAtual){
					element.text(data.saldo);
					$("#notificacao").get(0).play();
					$(".str-mp span").addClass('color-pulse-MP');
					timeEndAnimate = cont + 10;
					var loopLimit = 3;
					var loopCounter = 0;
					document.getElementById('notificacao').addEventListener('ended', function(){
						if (loopCounter < loopLimit){
							this.currentTime = 0;
							this.play();
							loopCounter++;
						}
					}, false);
				}
			}
		});
		if(timeEndAnimate > 0){
			if(timeEndAnimate == cont){
				$(".str-mp span").removeClass('color-pulse-MP');
			}
		}
	}	
}

jQuery.fn.center = function () {
    this.css("top", (screen.height - $(this).outerHeight() * 2) / 2 + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}
String.prototype.replaceAll = String.prototype.replaceAll || function(needle, replacement) {
    return this.split(needle).join(replacement);
};
function spc(idCliente,action,index){
	$.ajax({
		url : $(".pass-ganhos").attr("data-url-ajax") + "model/ajax/spc.php",
		type: "post",
		data : {idClt: idCliente, act: action},
		dataType: "json",
		success: function(data){
			if(data.status == 1 && action == 1){
				$(".rs-table tbody tr").eq(index).addClass("negative-line");
				setTimeout(function(){
					$(".rs-table tbody tr").eq(index).remove();
					$(".fixed-message-negativated").center().fadeIn();
					$(".nagative_menu").addClass("clt_negativado_menu");
					setTimeout(function(){
						$(".fixed-message-negativated").fadeOut();
						$(".nagative_menu").removeClass("clt_negativado_menu");
					},1400)
				},1500)
			}
			if(data.status == 1 && action == 0){
				$(".rs-table tbody tr").eq(index).addClass("reative-line");
				setTimeout(function(){
					$(".rs-table tbody tr").eq(index).remove();
					$(".fixed-message-reativated").center().fadeIn();
					setTimeout(function(){
						$(".fixed-message-reativated").fadeOut();
					},1400)
				},1500)
			}
			if(data.status == 0){
				alert("Falha ao atualizar cliente, cheque a conexão!");
			}
		},
		error: function(jqXHR, textStatus, msg) {
            alert("Falha ao atualizar cliente, cheque sua conexão! "+msg);
        }
	});
}
function setMenuContext(){
	if($(".rs-table thead tr th:nth-child(1) .th-inner ").text() == "ID-tbpedidos"){
		$(".rs-table tbody tr td").contextmenu(function(){
			var celActive = $(this);
			var position = celActive.offset();
			celActive.parents("tr").addClass("row_active_menu");
			$(".context-menu").fadeIn("Slow").css({left: position.left - 10, top: position.top - 110}).
			mouseleave(function(){
				$(this).fadeOut("fast");
				celActive.parents("tr").removeClass("row_active_menu");
			});
			return false;
		});
	}
}
function updatePronto(idPedido){
	$.ajax({
		url : $(".pass-ganhos").attr("data-url-ajax") + "/model/ajax/updateProntoAjax.php",
		data : {idPedido : idPedido},
		type: "post",
		dataType: "json",
		error: function(jqXHR, textStatus, msg) {
            alert("Falha ao atualizar, cheque sua conexão! ");
        },
		success: function(data){
			if(data.status == 0){
				$(".context-menu").fadeOut("Slow", function(){
					setMessagePopUp(0,"Pedido marcado como pronto");
					//$(".rs-table").find(".row_active_menu").remove();
					$(".rs-table").bootstrapTable('remove', {field: 'id', values: idPedido});
					$("#action_pronto").text("Marcar pedido como pronto");
				})
			}else{
				$(".context-menu").fadeOut("Slow", function(){
					setMessagePopUp(1,"Falha ao atualizar pedido");
					$("#action_pronto").text("Marcar pedido como pronto");
				});
			}
		}
	});
}
function updateFazendo(idPedido){
	$.ajax({
		url : $(".pass-ganhos").attr("data-url-ajax") + "/model/ajax/updateFazendoAjax.php",
		data : {idPedido : idPedido},
		type: "post",
		dataType: "json",
		error: function(jqXHR, textStatus, msg) {
            alert("Falha ao atualizar, cheque sua conexão! ");
        },
		success: function(data){
			if(data.status == 0){
				$(".context-menu").fadeOut("Slow", function(){
					setMessagePopUp(0,"Pedido esta em andamento");
					$(".rs-table").find(".row_active_menu").addClass("pdd_emandamento");
					$("#action_fazendo").text('Marcar como "em andamento"');
				})
			}else{
				$(".context-menu").fadeOut("Slow", function(){
					setMessagePopUp(1,"Falha ao atualizar pedido");
					$("#action_fazendo").text('Marcar como "em andamento"');
				});
			}
		}
	});
}
function setMessagePopUp(type,msg){
	if(type == 1){
		var content = $(".fixed-message-negativated");
		content.children("span").text(msg).fadeIn();
		content.center().fadeIn();
		setTimeout(function(){
			content.fadeOut();
		},2400)
	}
	if(type == 0){
		var content = $(".fixed-message-reativated");
		content.children("span").text(msg).fadeIn();
		content.center().fadeIn();
		setTimeout(function(){
			content.fadeOut();
		},1400)
	}
}
function searchPddEmAdmt(){
	time = 10000;
	intervalo = setInterval(function(){
		$.ajax({
		url : $(".pass-ganhos").attr("data-url-ajax") + "/model/ajax/updateFazendoInterval.php",
		type: "post",
		success: function(data){
			if(typeof(data.error) == 'undefined'){
				var idsAction = $.map(JSON.parse(data), function(value, name){
					return [value];
				});
				$(".rs-table tbody tr").each(function(){
					var idCel = $(this).children("td").eq(0).text();
					if(idsAction.indexOf(idCel) !== -1){
						if(!$(this).hasClass("pdd_emandamento")){
							$(this).addClass("pdd_emandamento");
							var loopLimit = 3;
							var loopCounter = 0;
							$("#notificacao2").get(0).play();
							document.getElementById('notificacao2').addEventListener('ended', function(){
								if (loopCounter < loopLimit){
									this.currentTime = 0;
									this.play();
									loopCounter++;
								}
							}, false);
						}
					}
				});
			}else{
				setMessagePopUp(1,"Falha ao checar atualizações! verifique sua conexão");
			}
		}
		});
	}, time);
}
function searchAdress(){
	$(".content-loader").fadeIn();
	var rua = $(".rua").val().replaceAll(" ","+");
	$.ajax({
		url : "https://viacep.com.br/ws/PR/"+$(".select-cidade option:selected").text()+"/"+rua+"/json/",
		type: "post",
		dataType: "json",
		error: function(jqXHR, textStatus, msg) {
            $(".content-loader").fadeOut();
        },
		success: function(data){
			if(data.length > 0){
				$(".cep").val(data[0].cep)
				$(".bairro").val(data[0].bairro);
			}else{
				$(".cep").val("")
			}
			$(".select-cidade option").each(function(){
				if(data.length > 0){
					if($(this).text().toLowerCase() == data[0].localidade){
						$(this).attr("selected","selected");
						$( ".select-cidade" ).select2();
						$(".numero").focus();
					}
				}
			});
			$(".content-loader").fadeOut();
		}
	})
}