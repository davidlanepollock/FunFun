<?php

class login_model extends Model {

    public function __construct() {
        parent::__construct();
    }

    private function logsess($id, $type, $pic, $username) {
        Sessions::set('testCookie', 'set!');
        if (Sessions::get('testCookie') === 'set!') {
            $_SESSION['uid'] = $id;
            $_SESSION['type'] = $type;
            $_SESSION['pic'] = $pic;
            $_SESSION['uname'] = $username;
            return true;
        } else {
            return false;
        }
    }

    private function sendNotification($tagline, $message) {
        $temp = new Notifications();
        $image = "public_files/includes/global.png";
        $content = $message;
        $title = $tagline;
        $temp->post($title, $content, $image);
        return false;
    }

    public function log_user($email, $password) {

        if (empty($email) != true && empty($password) != true) {
           
            $db = $this->database;
            $password = hash('sha256', trim(strip_tags(stripslashes($password))));
            $query = $db->select("SELECT * FROM users WHERE email='{$email}' && password='{$password}'");
            if ($db->getRowCount($query) == 1) {
                $this->log_tests($query, $db);
            } else {
                $this->sendNotification("Whoops..", '<div class="response">Sorry those credentials were wrong</div>' . $email);
               // $this->updateCount($email, $db);
                
                return false;
            }
        } else {
            $this->sendNotification("Whoops..", '<div class="response">Please fill in the fields.</div>');
            return false;
        }
    }

    private function log_tests($query, $database) {
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $status = $fetch['account_activated'];
        $uid = $fetch['id'];
        $propic = $fetch['pro_pic'];
        $uname = $fetch['username'];
        $attempts = $fetch['login_attempts'];
        switch ($status) {
            case '1':
                $this->login($uid, 0, $propic, $uname, $database);
                break;
            case '2':
                $this->sendNotification("Whoops..", "<div class='response'>Your account is locked</div>");
                return false;
                break;
            case '3':
                $this->sendNotification("Whoops..", "<div class='response'>Sorry your account is blocked</div>");
                return false;
                break;
        }
    }

    private function login($uid, $status, $propic, $uname, $database) {
        if ($this->logsess($uid, $status, $propic, $uname)) {
            $this->resetCount($uname, $database);
            echo "log_user";
        } else {
            $this->sendNotification("Whoops..", 'Please enable your cookies!');
        }
    }

    private function updateCount($email, $database) {
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $database->prepare("UPDATE users SET login_attempts = login_attempts + 1 WHERE email = :uemail");
        $query->bindParam(':uemail', $email);
        $query->execute();
        echo $query->rowCount();
    }

    private function resetCount($username, $database) {
        $query = $database->prepare("UPDATE users SET login_attempts = 0 WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();
    }

}

?>