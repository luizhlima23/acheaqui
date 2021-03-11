$(document).ready(function(){

	$.when(
		// $.getScript( app.url+"/js/inputmask/inputmask.js" ),
		// $.getScript( app.url+"/js/inputmask/inputmask.date.extensions.js" ),
		// $.getScript( app.url+"/js/inputmask/inputmask.phone.extensions.js" ),
		// $.getScript( app.url+"/js/inputmask/jquery.inputmask.js" ),
		$.Deferred(function( deferred ){
			$( deferred.resolve );
		})
	).done(function(){

		// PHONE masks
		$('.phone-mask').inputmask({
			mask: ["n 9999-9999", "9999-9999"],
			greedy: false,
			definitions: {
				'9': {
					validator: "[0-9]",
				},
				'n': {
					validator: "[9]",
				}
			}
		});
		$('.ddd_phone-mask').inputmask({
			mask: ["(99) n 9999-9999", "(99) 9999-9999"],
			greedy: false,
			definitions: {
				'9': {
					validator: "[0-9]",
				},
				'n': {
					validator: "[9]",
				}
			}
		});
		$('.date-mask').inputmask({
			alias: "date",
			placeholder: "__/__/____",
		});
		// HOUR masks
		$('.hour-mask').inputmask({
			alias: "hh:mm",
			placeholder: "__:__",
		});
		// DATE_HOUR masks
		$('.datetime-mask').inputmask({
			alias: "datetime",
			placeholder: "__/__/____ __:__",
		});
		// CPF masks
		$('.cpf-mask').inputmask({
			mask: ["999.999.999-99"],
			greedy: false,
			definitions: {
				'*': {
					validator: "[0-9]",
				}
			}
		});
		// CNPJ
		$('.cnpj-mask').inputmask({
			mask: ["99.999.999/9999-99"],
			greedy: false,
			definitions: {
				'*': {
					validator: "[0-9]",
				}
			}
		});

	});

});