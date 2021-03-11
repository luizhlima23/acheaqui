$(document).ready(function(){

	// TOOGLE - (onready)
	var toggleCheck = "#toggleCheck";
	if ($(toggleCheck).is(':checked')) {
		
		$("#toogleDiv *").removeAttr('disabled');
		$("#toogleDiv").show();
		
		// ContatoInformal
		if ($('#ContatoInformal').is(':checked')) {

			$('.disableOnCheck').prop('disabled', true);
		}
		else{

			$('.disableOnCheck').prop('disabled', false);
		}
	}
	else{

		$("#toogleDiv *").attr('disabled', 'disabled');
		$("#toogleDiv").hide();
	}

	// TOOGLE - (onclick)
	$(toggleCheck).on('click', function () {

		var boxToogle = $(this).attr('data-toggle-id');

		if ($(this).is(':checked')) {
			
			$("#toogleDiv *").removeAttr('disabled');
			$(boxToogle).show(400);
		}
		else{

			$("#toogleDiv *").attr('disabled', 'disabled');
			$(boxToogle).hide(400);
		}
	});

});