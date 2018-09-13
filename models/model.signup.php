<?php

class signup_model extends Model {

    private $username;
    private $propic;
    private $type;
    private $id;

    public function __construct() {
        parent::__construct();
    }

    private function log_sess() {
        Sessions::set('testCookie', 'set!');
        if(Sessions::get('testCookie') === 'set!')
        {
        Sessions::set('uid', $GLOBALS['id']);
        Sessions::set('type', $GLOBALS['type']);
        Sessions::set('pic', $GLOBALS['propic']);
        Sessions::set('uname', $GLOBALS['username']);
        return true;
        }
        else{
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

    public function signup_post($firstname, $lastname, $username, $email, $password) {
        if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($password)) {
            $db = $this->database;
            $query = $db->select("SELECT * FROM users WHERE email='{$email}' OR username='{$username}'");
            if ($query->rowCount() == 1) {
                $this->sendNotification("Whoops..", "Sorry someone with that username or email already exists!");
            } else {
                $this->insertintoDB($db, $firstname, $lastname, $email, $password, $username);
            }
        } else {
            $this->sendNotification("Whoops..", "Please fill in all fields.");
        }
    }

    private function insertintoDB($database, $fname, $lname, $email, $password, $username) {
        $password = hash('sha256', trim(strip_tags(stripslashes($password))));
        $type = 1;
        $activated = 1;
        $login_attempts = 0;
        $default_value = '';
        //$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $database->prepare("INSERT INTO users"
                . " (f_name, l_name, email, account_type, account_activated,"
                . " pro_pic, bio, password, username, login_attempts)"
                . " VALUES(:firstname, :lastname, :uemail, :account_types, "
                . " :at_activated, :pro_pics, :bios, :upassword,"
                . " :uname, :l_attempts)");
        $query->bindParam(':firstname', $fname);
        $query->bindParam(':lastname', $lname);
        $query->bindParam(':uemail', $email);
        $query->bindParam(':account_types', $type);
        $query->bindParam(':at_activated', $activated);
        $query->bindParam(':pro_pics', $default_value);
        $query->bindParam(':bios', $default_value);
        $query->bindParam(':upassword', $password);
        $query->bindParam(':uname', $username);
        $query->bindParam(':l_attempts', $login_attempts);
        $query->execute();
        if ($query->rowCount() !== 0) {
            $GLOBALS['username'] = $username;
            $GLOBALS['type'] = $type;
            $GLOBALS['propic'] = $default_value;
            $GLOBALS['id'] = $this->get_id($username, $database);
            if($this->log_sess())
            {
            echo 'log-user';
            }else{
                $this->sendNotification("Success, but", "cookies must be enabled before you can log in!");
            }
        } else {
            $this->sendNotification("Whoops..", "Error inserting into table!"
                    . $fname . $lname . $email . $type . $activated . $password .
                    $username . $login_attempts);
        }
    }

    private function get_id($username, $database) {
        $query = $database->prepare("SELECT id from users WHERE username = :username LIMIT 1");
        $query->bindParam(':username', $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

}
