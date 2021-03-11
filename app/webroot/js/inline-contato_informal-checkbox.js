$(document).ready(function(){
		
	// Disabel inputs
	$('#ContatoInformal').change(function(){

		if ($(this).is(':checked')) {

			$('.disableOnCheck').prop('disabled', true);
		}
		else{

			$('.disableOnCheck').prop('disabled', false);
		}

	}).change();


});

