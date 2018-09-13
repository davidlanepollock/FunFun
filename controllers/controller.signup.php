<?php

class signup extends Controller {

    public function main() {
        parent::__construct();
        if(Sessions::get('uid'))
        {
            header("location: " . APP_URL . "/home");
        }
        $this->view->title = "Signup | Website";
        $this->view->stylesheet = "signup.css";
        $this->view->render('signup/main');
    }

    public function signup_user() {
        $this->loadModel('signup');
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
            $this->model->signup_post(trim(strip_tags(stripslashes($_POST['firstname']))), trim(strip_tags(stripslashes($_POST['lastname']))), trim(strip_tags(stripslashes($_POST['username']))), trim(strip_tags(stripslashes($_POST['email']))), trim(strip_tags(stripslashes($_POST['password']))));
        }
    }

}

?>