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
			if(link!=undefined){
				window.location = link;
				
			}
			break;
			
			case 39:
			var link = $("#rightbutton").attr('href');
			if(link!=undefined){
				window.location = link;
			}
			console.log($("#rightbutton"));
			break;
		}
	});
	
	$(document).ready(function () {
	  if (!Notification) {
		alert('Desktop notifications not available in your browser. Try Chromium.'); 
		return;
	  }

	  if (Notification.permission !== "granted")
		Notification.requestPermission();
	});

	function notifyMe() {
	  if (Notification.permission !== "granted")
		Notification.requestPermission();
	  else {
		var notification = new Notification('Notification title', {
		  icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
		  body: "Hey there! You've been notified!",
		});

		notification.onclick = function () {
		  window.open("http://stackoverflow.com/a/13328397/1269037");      
		};

	  }

	}
});
$(document).on("pageinit",function(){
	$(document).on("swipeleft",function(){
		var link = $("#rightbutton").attr('href');
		if(link!=undefined){
			window.location = link;
			
		}
		console.log('asd');
	});
	console.log("asd");
	$(document).on("swiperight",function(){
		var link = $("#leftbutton").attr('href');
		if(link!=undefined){
			window.location = link;
			
		}
	});
});