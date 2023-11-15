var root = document.documentElement;
root.className += ' js';

function boxTop(idBox) {
	var boxOffset = $(idBox).offset().top;
	return boxOffset;
}

$(document).ready(function () {
	$('.telefone')
			.mask("(99) 9999-9999?9")  
			.on('focusout', function (event) {  
			var target, phone, element;  
			target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
			phone = target.value.replace(/\D/g, '');  
			element = $(target);  
			element.unmask();  
			if(phone.length > 10) {  
			element.mask("(99) 99999-999?9");  
			} else {  
			element.mask("(99) 9999-9999?9");  
		} 
	});

	$('.data').mask("99/99/9999");

	$('.cpf').mask("999.999.999-99");

	$(".disable-click").click(function(e) {
		e.preventDefault();
	});

	$("#menu-principal").on('click', function (e) {
    	if ($(e.target).closest(".navbar-nav").length === 0) {
			$("#menu-principal").fadeOut('slow');
	    }
	});

	$(".navbar-toggler").click(function(e) {
		e.preventDefault();
		$("#menu-principal").fadeIn('slow');
	});

	$(".close-navbar").click(function(e) {
		e.preventDefault();
		$("#menu-principal").fadeOut('slow');
	});

	//enviar formularios
	$(".form").submit(function(e){
		e.preventDefault();
		$(".form .btn").html('<img src="templates/img/loader.gif" class="loaded" height="20" />')
		$(".form .btn").prop('disabled', true);
		var formData = new FormData(this);		
		var formObj = $(this);		
		var formURL = formObj.attr("action"); // URL para envio do POST		
		if(window.FormData !== undefined){
			$.ajax({
				url: formURL,
				type: 'POST',
				data:  formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(data, textStatus, jqXHR){
					$(".form .btn").html('Enviar Mensagem')
					$(".form .btn").prop('disabled', false);
					$("#retorno").html(data);
				},
				error: function(jqXHR, textStatus, errorThrown){
					$(".form .btn").html('Enviar Mensagem')
					$(".form .btn").prop('disabled', false);
					$("#retorno").html(data);
				} 	        
			});
			//e.unbind();
		}else{
			var  iframeId = 'unique' + (new Date().getTime());
			var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
			iframe.hide();
			formObj.attr('target',iframeId);
			iframe.appendTo('body');
			iframe.load(function(e){
				var doc = getDoc(iframe[0]);
				var docRoot = doc.body ? doc.body : doc.documentElement;
				var data = docRoot.innerHTML;
				$("#retorno, #retorno_popup").html(data);
			});
		}
	});

	$('.abre-contato').click(function(e) {
		e.preventDefault();
		$('#contato').modal('show')
	});

	if ($('#owl-diferenciais').length) {
	    var owl = $('#owl-diferenciais');
	    owl.owlCarousel({
	        nav: true,
	        loop: true,
	        slideBy: 1,
	        autoplay: true,
            lazyLoad:true,
	        responsive: {
	            0: {
		            margin: 0,
	                items: 1
	            }, 768: {
		            margin: 40,
	                items: 2
	            }, 992: {
		            margin: 50,
	                items: 3
	            }
	        }
	    });
	}

	if ($('#owl-cases').length) {
	    var owl = $('#owl-cases');
	    owl.owlCarousel({
	        nav: true,
	        loop: true,
	        slideBy: 1,
	        autoplay: true,
            margin: 30,
            lazyLoad:true,
	        responsive: {
	            0: {
	                items: 1
	            }, 768: {
	                items: 2
	            }, 992: {
	                items: 3
	            }
	        }
	    });
	}

	if ($('#owl-parceiros').length) {
	    var owl = $('#owl-parceiros');
	    owl.owlCarousel({
	        nav: true,
	        loop: true,
	        slideBy: 1,
	        autoplay: true,
            margin: 0,
            lazyLoad:true,
	        responsive: {
	            0: {
	                items: 2
	            }, 768: {
	                items: 3
	            }, 992: {
	                items: 5
	            }
	        }
	    });
	}

	if ($('#owl-depoimentos').length) {
	    var owl = $('#owl-depoimentos');
	    owl.owlCarousel({
	        nav: true,
	        loop: true,
	        slideBy: 1,
	        autoplay: true,
	        autoplayTimeout: 15000,
            margin: 0,
            lazyLoad:true,
            items: 1,
            autoHeight:true
	    });
	}

	if ($('#owl-galeria').length) {
	    var owl = $('#owl-galeria');
	    owl.owlCarousel({
	        nav: true,
	        loop: true,
	        slideBy: 1,
	        autoplay: false,
            margin: 0,
            lazyLoad:true,
            items: 1,
            autoHeight: true
	    });
	}
});

$(window).on("load", function (e){
	var $target = $('.anime'),
	animationClass = 'animacaoAtiva',
	windowHeight = $(window).height(),
	offset = windowHeight;

	function animeScroll() {
		var documentTop = $(document).scrollTop();
		$target.each(function() {
			if (documentTop > boxTop(this) - offset) {
				$(this).addClass(animationClass);
			}
		});
	}
	animeScroll();

	$(document).scroll(function() {
		animeScroll();
	});
});