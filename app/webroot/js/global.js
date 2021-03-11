$(document).ready(function(){
	
	// Flash Box
	$( "#divFlash .slideDown" ).delay( 400 ).slideDown( 800 );

	// Form value Submit();
	$('body').on('click', '.valuesubmit', function(e) {
		var valor = $(this).attr('data-param');
		$(".formvaluesubmit").val( valor );
		$('#ContatoPesquisaForm').submit();
	});

	// Filtro rápido de tabela
	(function ($) {

		$('#filter_table').keyup(function () {

			var rex = new RegExp($(this).val(), 'i');
			$('.searchable tr').hide();
			$('.searchable tr').filter(function () {
				return rex.test($(this).text());
			}).show();

		})

	}(jQuery));

	// Responsive pagination
	$(".pagination").rPage();
		
	// ToTop
	$(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();   
		} 
		else {
			$('#toTop').fadeOut(); 
		}
	});
	$('#toTop').click(function() {
		$('body,html').animate({
			scrollTop:0
		},800); 
	});

	// Loading Button
	$('form').on('submit', function(e) {
		var btn = $('#loadButton').button('loading')
	});

	// Tooltips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

	// Radio reset
	$('.radioReset').on('click', function() {
		var name = $(this).attr("data-radio-name"); 
		$('input[name="'+name+'"]').prop('checked', function () {
			return this.getAttribute('checked') == 'checked';
		});
	})

	// Pesquisa com valor em links
	$('body').on('click', '.valuesubmit', function(e) {
		var valor = $(this).attr('data-param');
		$(".formvaluesubmit").val( valor );
		$('#ContatoPesquisaForm').submit();
	});

	// $('.modelo-1').on("taphold",function(){
	// 	alert('em breve um menu aqui');

		// e.stopPropagation();
		// $(this).simpledialog2({
		// 	mode:"blank",
		// 	headerText:"Image Options",
		// 	showModal:true,
		// 	forceInput:true,
		// 	headerClose:true,
		// 	blankContent:"<ul data-role='listview'><li><a href=''>Send to Facebook</a></li><li><a href=''>Send to Twitter</a></li><li><a href=''>Send to Cat</a></li></ul>"
		// });
	// });
	
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

	// $('.modal-open').printThis();
});

// Exibe o número de caracteres digitados em um campo texto
function InputCharsLimit(box,value,span){
	
	var count = value - box.length;
	document.getElementById(span).innerHTML = count;

	if(box.length >= value){

		document.getElementById(span).innerHTML = "<font color='red'>0</font>";
		document.getElementById("campo").value = document.getElementById("campo").value.substr(0,value);
	}	
}
