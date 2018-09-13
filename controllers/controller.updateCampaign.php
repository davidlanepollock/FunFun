<?php
class updateCampaign extends Controller {
	public function  main(){
		$this->view->title = "Update Campaign | " . APP_NAME;
		$this->view->stylesheet = "home.css";
		$this->view->render('updateCampaign/main');
	}
	
	
}
?>