// Password View
$("#passwordfield").on("keyup",function(){
	
	if($(this).val())
		$(".show-icon").show();
	else
		$(".show-icon").hide();
});

$(".show-icon").mousedown(function(){
	$("#passwordfield").attr('type','text');
}).mouseup(function(){
	$("#passwordfield").attr('type','password');
}).mouseout(function(){
	$("#passwordfield").attr('type','password');
});