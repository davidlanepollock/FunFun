<?php

class login extends Controller {

    public function main() {
        parent::__construct();
        if(Sessions::get('uid'))
        {
            header("location: " . APP_URL . "/home");
      }
        $this->view->title = "Login | Website";
        $this->view->stylesheet = "login.css";
        $this->view->render('login/main');
    }

    public function login_user() {
        $this->loadModel('login');
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $this->model->log_user(trim(strip_tags(stripslashes($_POST['email']))), trim(strip_tags(stripslashes($_POST['password']))));
        }
        echo 'Enter username!';
        return false;
    }

}

?>