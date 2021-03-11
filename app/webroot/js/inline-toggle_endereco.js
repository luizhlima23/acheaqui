$(document).ready(function(){

	// TOOGLE - (onready)
	var toggleEndereco = "#toggleEndereco";
	if ($(toggleEndereco).is(':checked')) {
		
		$("#toogleDivEndereco *").attr('disabled', 'disabled');
		$("#toogleDivEndereco").hide();

		// Telefone
		$("#toggleFone").attr('required', true);
	}
	else{

		$("#toogleDivEndereco *").removeAttr('disabled');
		$("#toogleDivEndereco").show();

		// Telefone
		$("#toggleFone").attr('required', false);
	}

	// TOOGLE - (onclick)
	$(toggleEndereco).on('click', function () {

		var boxToogle = $(this).attr('data-toggle-id');

		if ($(this).is(':checked')) {

			$("#toogleDivEndereco *").attr('disabled', 'disabled');
			$(boxToogle).hide(400);

			// Telefone
			$("#toggleFone").attr('required', true);
		}
		else{
			
			$("#toogleDivEndereco *").removeAttr('disabled');
			$(boxToogle).show(400);

			// Telefone
			$("#toggleFone").attr('required', false);
		}
	});

});