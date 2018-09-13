<?php

class home extends Controller {

    public function main() {
        $this->view->title = $this->view->firstname . " | Website";
        $this->view->stylesheet = "home.css";
        $this->view->render('home/main');
    }

}

?>