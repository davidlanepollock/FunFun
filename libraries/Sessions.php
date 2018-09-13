<?php
class Sessions {
	public static function start_session(){
		session_start();
	}

	public static function destroy_session($session_name){
		if(isset($_SESSION[$session_name]) || empty($_SESSION[$session_name]) != true){
			unset($_SESSSION[$session_name]);
		}
	}

	public static function destroy_all_sessions(){
		if(isset($_SESSION)){
			session_unset();
			session_destroy();
		}
	}

	public static function set($name, $value){
		$_SESSION[$name] = $value;
	}

	public static function get($name){
		if(isset($_SESSION[$name])){
			return $_SESSION[$name];
		} else {
			return false;
		}
	}
}
?>