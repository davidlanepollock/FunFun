// JavaScript Document
$(function(){
	$("#loginForm").submit(function(){
		var email = $("#email").val();
		var password = $("#password").val();
		
			$.post('/login/login_user',{email: email, password: password},function(data){
				if(data === "log_user"){
					window.location.assign("home");	
				} else {
					$("#response").html(data);
				}
			});
		
	});
});