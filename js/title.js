$.title = function(elem) {
	var content = '<div class="ballom-title">',
	icon = '<img src="img/comuns/balao.png" />',
	elem = $(this);
	elem.hover(function(){
			var title = elem.attr("title"),
			position = elem.offset();
			if(title != "" && typeof(title) != "undefined"){
				$("body").append(content+"<p>"+title+"</p>"+icon+"</div>");
				$(".ballom-title").css({top: position.top, left: position.left});
			}
		},
		function(){
			//alert($("ballom-title").text());
			elem.remove();
	});
	
	/*this.each(function(){
		this.hover(function(){
			var title = this.attr("title"),
			position = this.offset();
			if(title != "" && typeof(title) != "undefined"){
				$("body").append(content+"<p>"+title+"</p>"+icon+"</div>");
				$(".ballom-title").css({top: position.top, left: position.left});
			}
		},
		function(){
			//alert($("ballom-title").text());
			this.remove();
		});
	});*/
	/*return this.each(function(){
		var elem = $(this);
		elem.mouseenter(addItem(elem));
	});
	function addItem(elem){
		var title = elem.attr("title"),
		position = elem.offset();
		$("body").append(content+"<p>"+title+"</p>"+icon+"</div>");
		$(".ballom-title").css({top: position.top, left: position.left});
	}
	delItem = function(){
	}*/
};