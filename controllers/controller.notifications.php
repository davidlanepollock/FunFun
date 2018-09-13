<?php
class notifications extends Controller {
	public function  main(){
		$this->view->title = $this->view->firstname . " | Website";
		$this->view->stylesheet = "notifications.css";
		$this->view->render('notifications/main');
	}
	
	public function getUser($user_name){
		parent::loadModel("profile");
		parent::__construct();
		
		if($user_name != ""){ 
			$user = trim(strip_tags(stripslashes($user_name)));
		
			$query = $this->model->database->select("SELECT * FROM users WHERE id='{$user}' AND activated='1' LIMIT 1");
			$fetch = $query->fetch(PDO::FETCH_ASSOC);
			$num = $query->rowCount();
				if($num == 1){
					$this->view->userid = $fetch['id'];
					$this->view->firstname = $fetch['fname'];
					$this->view->lastname = $fetch['lname'];
					$this->view->username = $fetch['username'];
					$this->view->bio = $fetch['bio'];
					$this->view->propic = $fetch['pro_pic'];
					$this->view->banner = $fetch['banner'];
					$this->view->account_status = $fetch['account_st'];
				} else {
					header("location: " . APP_URL . "login");	
				}
		} else {
			header("location: " . APP_URL . "login");
		}
	}
	
	public function makePost(){
		if(isset($_POST['postBody']) && isset($_POST['userTo'])){
			Posting::add_post(Sessions::get("uid"),$_POST['userTo'],$_POST['postBody'],'text',$_POST['privacy']);	
		}
	}
        public function addfriend(){		
			Posting::add_user(Sessions::get("uid"),$_POST['adduser']);	
		
	}
}
?>