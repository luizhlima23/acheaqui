$(document).ready(function(){
	
	//	Nicedit
	bkLib.onDomLoaded(function() {
		new nicEditor(
			{
				fullPanel : true, 
				iconsPath : app.url+'js/nicedit/nicEditorIcons.gif',
				// buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript'],
				maxHeight : 500
			}
		).panelInstance('documentoConteudo');
	});


});