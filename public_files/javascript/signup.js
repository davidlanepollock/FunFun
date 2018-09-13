$(function(){
	$("#signupForm").submit(function(){
		var firstname = $.trim($("#firstname").val());
		var lastname = $.trim($("#lastname").val());
		var username = $.trim($("#username").val());
		var email = $.trim($("#email").val());
		var password = $.trim($("#password").val());

			$.post('signup/signup_user',{firstname: firstname, lastname: lastname, username: username, email: email, password: password},function(data){
				if(data === "log-user"){
					window.location.assign("home");
				} else {
					$("#response").html(data);
				}
			});
		
	});
});