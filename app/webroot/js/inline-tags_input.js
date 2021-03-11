$(document).ready(function(){

	$.when(
		$.getScript( app.url+"/tags_input/bootstrap-tagsinput.js" ),
		$.Deferred(function( deferred ){
			$( deferred.resolve );
		})
	).done(function(){

		// TAGS INPUT
		var EtiquetaTags = $('#EtiquetaTags');
		EtiquetaTags.tagsinput({
			tagClass: 'label label-tag',
			confirmKeys: [13, 44],
			maxTags: 30,
			maxChars: 50,
			trimValue: true,
			allowDuplicates: false,
			cancelConfirmKeysOnEmpty: false
		});
		EtiquetaTags.on('change', function(){

			if(EtiquetaTags.val() == ''){
				var count = 0;
			}
			else{
				var count = EtiquetaTags.val().split(",").length;
			}

			$( "#tagsCount" ).text("Total: "+count+" / 30");
		});

	});

});