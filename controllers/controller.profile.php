<?php

class profile extends Controller {

    public function main() {
        $this->view->title = $this->view->firstname . " | Website";
        $this->view->stylesheet = "profile.css";
        $this->view->render('profile/main');
    }

    public function main2() {
        $this->getUserbyID(Sessions::get('uid'));
        $this->view->title = $this->view->firstname . " | Website";
        $this->view->stylesheet = "profile.css";
        $this->view->render('profile/main');
    }

    public function getUser($user_name) {
        parent::loadModel("profile");
        parent::__construct();

        if ($user_name != "") {
            $user = trim(strip_tags(stripslashes($user_name)));

            $query = $this->model->database->select("SELECT * FROM users WHERE username='{$user}' AND account_activated='1' LIMIT 1");
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $num = $query->rowCount();
            if ($num == 1) {
                $this->view->userid = $fetch['id'];
                $this->view->firstname = $fetch['f_name'];
                $this->view->lastname = $fetch['l_name'];
                $this->view->username = $fetch['username'];
                $this->view->bio = $fetch['bio'];
                $this->view->propic = $fetch['pro_pic'];
                $this->view->account_status = $fetch['account_type'];
            } else {
                header("location: " . APP_URL . "login");
            }
        } else {
            header("location: " . APP_URL . "login");
        }
    }
    private function getUserbyID($id)
    {
        parent::loadModel("profile");
        parent::__construct();

        if ($id != "") {

            $query = $this->model->database->select("SELECT * FROM users WHERE id='{$id}' AND account_activated='1' LIMIT 1");
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $num = $query->rowCount();
            if ($num == 1) {
                $this->view->userid = $fetch['id'];
                $this->view->firstname = $fetch['f_name'];
                $this->view->lastname = $fetch['l_name'];
                $this->view->username = $fetch['username'];
                $this->view->bio = $fetch['bio'];
                $this->view->propic = $fetch['pro_pic'];
                $this->view->account_status = $fetch['account_type'];
            } else {
                header("location: " . APP_URL . "login");
            }
        } else {
            header("location: " . APP_URL . "login");
        }
    }

    public function makePost() {
        if (isset($_POST['postBody']) && isset($_POST['userTo'])) {
            Posting::add_post(Sessions::get("uid"), $_POST['userTo'], $_POST['postBody'], 'text', $_POST['privacy']);
        }
    }

    public function addfriend() {
        Posting::add_user(Sessions::get("uid"), $_POST['adduser']);
    }

}

?>