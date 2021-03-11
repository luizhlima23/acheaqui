$(document).ready(function(){

	// Categorias de autocomplete	    
	$.widget( "custom.catcomplete", $.ui.autocomplete, {
		_create: function() {
			this._super();
			this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
		},
		_renderItemData: function( ul, item ) {
			if( item.category == 'vermais' ){
				return this._renderItemHtml( ul, item ).data( "ui-autocomplete-item", item );
			}
			else{
				return this._renderItem( ul, item ).data( "ui-autocomplete-item", item );
			}
		},
		_renderItemHtml: function( ul, item ) {
			return $( "<li class='"+item.class+"'>" )
			.append( item.link )
			.appendTo( ul );
		},
		_renderItem: function( ul, item ) {
			return $( "<li class='"+item.class+"'>" )
			.append( $( "<a>" ).html( item.label ) )
			.appendTo( ul );
		},
		_renderMenu: function( ul, items ) {
			var that = this,
			currentCategory = "";
			$.each( items, function( index, item ) {
				var li;

				if ( item.category != currentCategory && item.category != 'vermais' ) {
					ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
					currentCategory = item.category;
				}

				li = that._renderItemData( ul, item );
				if ( item.category ) {
					li.attr( "aria-label", item.category + " : " + item.label );
				}

			});
		}
	});

	// Auto Complete
	$( "#inpBusca" ).catcomplete({
		minLength: 3,
		autoFocus: false,
		delay: 0,
		source: function( request, response ) {
			$.ajax({
				url: app.url+"/contatos/auto_completar.json",
				dataType: "jsonp",
				data: {
					q: request.term
				},
				success: function( data ) {
					response( data );
				}
			});
		},
		focus: function( event, ui ) {},
		select: function( event, ui ) {
			$( "#inpBusca" ).val( ui.item.value );
			$('#ContatoPesquisaForm').submit();
			return false;
		},
		open: function() {
			$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
	});

});