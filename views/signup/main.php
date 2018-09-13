<br /><script src='<?= APP_URL; ?>/public_files/javascript/signup.js'></script>

<div class='signup-middle'>
	<div class='sm-head'>
		<h3>Sign up! Its free.</h3>
	</div>
	<div class='inner-sm'>
		<div class='form-cont'>
			<form action='<?= APP_URL; ?>/signup/signup_user' method='post' id='signupForm' onSubmit='return false;'>
				<div class='inputField'>
					<input type='text' name='firstname' id='firstname' placeholder='First Name' />
				</div>
				<div class='inputField'>
					<input type='text' name='lastname' id='lastname' placeholder='Last Name' />
				</div>
				<div class='inputField'>
					<input type='text' name='username' id='username' placeholder='Username' />
				</div>
				<div class='inputField'>
					<input type='email' name='email'  id='email' placeholder='Email' />
				</div>
				<div class='inputField'>
					<input type='password' name='password' id='password' placeholder='Password' />
				</div>
				<div class='inputField'>
					<input type='submit' name='submiter' value='Sign up!' />
				</div>
			</form>
		</div> <span style='' id='response'></span>
	</div>
</div>