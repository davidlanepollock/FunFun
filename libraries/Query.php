<?php

class Query {

    public static function not_type($num) {
        switch ($num) {
            case 0: return "liked your ";
            case 1: return "commented on your ";
            case 2: return "subscribed to your ";
            case 3: return "accepted your ";
            case 4: return "sent you a ";
        }
    }

    public static function not_value($num) {
        switch ($num) {
            case 0: return "status";
            case 1: return "photo";
            case 2: return "new friendship";
            case 3: return "friend request";
        }
    }

    public static function not_value_links($num) {
        switch ($num) {
            case 0: return "status";
            case 1: return "photos";
            case 2: return "friends";
            case 3: return "friendrequests";
        }
    }

    public static function specialkey() {
        return 19623;
    }

    public static function post_type($num) {
        switch ($num) {
            case 0: return "users";
            case 1: return "pages";
        }
    }

    public static function username($user, $type) {
        switch ($type) {
            case 0: $db = "users";
            case 1: $db = "pages";
        }
        $query = Database::select("SELECT * FROM '{$db}' WHERE id='{$user}'");
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $value = $fetch['username'];
        return $value;
    }

    public static function name($user, $type) {
        switch ($type) {
            case 0: $db = "users";
        }
        if ($db === 'users') {
            $query = Database::select("SELECT * FROM users WHERE id='{$user}'");
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $value = $fetch['fname'] . ' ' . $fetch['lname'];
        } else {
            $query = Database::select("SELECT * FROM pages WHERE page_id='{$user}'");
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $value = $fetch['pagename'];
        }
        return $value;
    }

}
