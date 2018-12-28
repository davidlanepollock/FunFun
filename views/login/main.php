<br /><script src='<?= APP_URL; ?>/public_files/javascript/login.js'></script>
<div class="core">
<div class='signup-middle'>
	<div class='sm-head'>
            <h3>Login to <?= APP_NAME; ?>'s System</h3>
            <div class="piclog">
            <img width="60px" height="60px"/>
            <img width="60px" height="60px"/>
            <img width="60px" height="60px"/>
            <img width="60px" height="60px"/>
            <img width="60px" height="60px"/>
            <img width="60px" height="60px"/>
            </div>
	</div>
	<div class='inner-sm'>
		<div class='form-cont'>
			<form action='<?= APP_URL; ?>login/login_user' method='post' id='loginForm' onSubmit='return false;'>
				<div class='inputField'>
					<input type='email' name='email'  id='email' placeholder="Email<?= Sessions::get('uid'); ?>" />
				</div>
				<div class='inputField'>
					<input type='password' name='password' id='password' placeholder='Password' />
				</div>
				<div class='inputField'>
					<input type='submit' name='submiter' value='Login' /> 
				</div>
			</form>
		</div><span style='' id='response'></span>
	</div>
</div>
</div>