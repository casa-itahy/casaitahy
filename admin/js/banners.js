
$.noConflict();

jQuery(document).ready(function () {
	jQuery('#grupo').change(function() {
		if (jQuery('#grupo').val() == 1) {
			jQuery('#campoExtra').css('display','block');
		} else {
			jQuery('#campoExtra').css('display','none');
		}
	});	
});