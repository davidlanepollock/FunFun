<?php
class index extends Controller {
	public function  main(){
		parent::__construct();
		$this->view->title = "Welcome";
		$this->view->stylesheet = "index.css";
		$this->view->render('index/main');
	}
}
?>