$(document).ready(function(){
	$('#username_input').focus();
	var state = false;
	$('.faszkalap').click(function(){
		var user = $($(this).parent().parent().parent().children()[1]).children().text()
		if(state==false){
			$('#box').css('display','block');
			$('#hidden').val(user);
			$('#password_input').focus();
			state = true;
		}else{
			$('#box').css('display','none');
			state = false;
		}
	});
	$(document).keydown(function(e){
		switch(e.which) {
			case 37:
			var link = $("#leftbutton").attr('href');
			console.log($("#leftbutton"));
			break;
			
			case 39:
			var link = $("#rightbutton").attr('href');
			
			console.log($("#rightbutton"));
			break;
		}
	});
});