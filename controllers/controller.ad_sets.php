<?php
class ad_sets extends Controller {
	public function  main(){
		$this->view->title = $this->view->pagename . " | Website";
		$this->view->stylesheet = "home.css";
		$this->view->render('ad_sets/main');
	}
	
	
}
?>