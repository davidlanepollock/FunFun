<?php
class campaign extends Controller {
	public function  main(){
		$this->view->title = $this->view->pagename . " | Website";
		$this->view->stylesheet = "home.css";
		$this->view->render('campaign/main');
	}
	
	
}
?>