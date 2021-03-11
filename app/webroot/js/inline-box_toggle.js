$(document).ready(function(){
		
	// Box Toggle
	$('.boxToggle').change(function(){

		var boxID = $(this).attr('data-toggle-id');
		var value = $(this).attr('data-toggle-value');
		if($(this).val() == value){

			$(boxID).slideDown(500);
			$(boxID+" *").removeAttr('disabled');
		}
		else{

			$(boxID).slideUp(500);
			$(boxID+" *").attr('disabled', 'disabled');
		}
	}).change();

});