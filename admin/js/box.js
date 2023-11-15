$(document).ready(function () {
	
	var valor = $('#grupo').val();
		
	if (valor != 0) {
		$('#windowcontent').css('display', 'none').css('display', 'block');
	} else {
		$('#windowcontent').css('display', 'none');
	}
	
	$('#grupo').change(function() {
	
		var valor = $('#grupo').val();
		
		if (valor != 0) {
			$('#windowcontent').css('display', 'block');
		} else {
			$('#windowcontent').css('display', 'none');
		}
		
	});	
});