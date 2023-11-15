function valida_form(form) {
    var req = 0;
    var emailfilter = /^[a-z0-9]+([_.-][a-z0-9]+)*@[a-z0-9]+([_.-][a-z0-9]+)*[.]+[a-z0-9]{2,4}$/i;
    $( form ).find('.inputC').each(function(){
		if($("#nomeC").val()== "" ){
			$('#nomeC').css({'border-color': '#f00'});
			$('#nomeC').click(function() {
				$('#nomeC').removeAttr('style');	
			});
			$('#nomeC').focus(function(){
				$('#nomeC').removeAttr('style');
			});
		    req += 1;
		}

		if( !emailfilter.test( $("#emailC").val() ) ) {
			$('#emailC').css({'border-color': '#f00'});
			$('#emailC').click(function() {
				$('#emailC').removeAttr('style');	
			});
			$('#emailC').focus(function(){
				$('#emailC').removeAttr('style');
			});
		    req += 1;
		}

		if($("#telefoneC").val()== "" ){
			$('#telefoneC').css({'border-color': '#f00'});
			$('#telefoneC').click(function() {
				$('#telefoneC').removeAttr('style');
			});
			$('#telefoneC').focus(function(){
				$('#telefoneC').removeAttr('style');
			});
		    req += 1;
		}
    });     
    return !req;	
}

function valida_form2(form) {
    var req = 0;
    var emailfilter = /^[a-z0-9]+([_.-][a-z0-9]+)*@[a-z0-9]+([_.-][a-z0-9]+)*[.]+[a-z0-9]{2,4}$/i;
    $( form ).find('.inputO').each(function(){
		if($("#nomeO").val()== "" ){
			$('#nomeO').css({'border-color': '#f00'});
			$('#nomeO').click(function() {
				$('#nomeO').removeAttr('style');	
			});
			$('#nomeO').focus(function(){
				$('#nomeO').removeAttr('style');
			});
		    req += 1;
		}

		if( !emailfilter.test( $("#emailO").val() ) ) {
			$('#emailO').css({'border-color': '#f00'});
			$('#emailO').click(function() {
				$('#emailO').removeAttr('style');	
			});
			$('#emailO').focus(function(){
				$('#emailO').removeAttr('style');
			});
		    req += 1;
		}

		if($("#telefoneO").val()== "" ){
			$('#telefoneO').css({'border-color': '#f00'});
			$('#telefoneO').click(function() {
				$('#telefoneO').removeAttr('style');
			});
			$('#telefoneO').focus(function(){
				$('#telefoneO').removeAttr('style');
			});
		    req += 1;
		}
    });     
    return !req;	
}