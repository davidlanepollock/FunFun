<?php
class View {
	public function render($page, $header = 1){
		if(empty($page) != true && empty($header) != true){
			if($header == 1){
				require VIEWS_ROOT . 'header.php';
				require VIEWS_ROOT . $page . '.php';
                                require VIEWS_ROOT . 'footer.php';
			} else if($header == 0) {
				require VIEWS_ROOT . $page . '.php';
			}
		}
	}
}