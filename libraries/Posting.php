<?php

/* Posting System Library */

class Posting {

    public static function add_post($userby, $userto, $body, $type, $typeto, $typeby) {
        if (empty($userby) != true) {
            $userto = Database::clean($userto);
            $userby = Database::clean($userby);
            $type = Database::clean($type);
            $privacy = Database::clean($privacy);
            $body = Database::clean($body);
            $typeto = Database::clean($typeto);
            $typeby = Database::clean($typeby);
            /* Render The Post Type */
            switch ($type) {
                case 'text':
                    $posttype = "text";
                    break;
            }
            $date = date("y:m:d h:i:s");
            $array = ['', $userby, $userto, '', $body, $date, '0', $typeto, $typeby];
            $database = Database::insert("posts", $array);
            /* Get users info */
            $query = Database::select("SELECT * FROM users WHERE id='{$userby}'");
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
            $firstname = $fetch['fname'];
            $lastname = $fetch['lname'];
            $profile_pic = $fetch['propic'];
            $username = $fetch['username'];

            /* Now echo out the post */
            echo "yep";
        } else {
            die("Empty-fields");
        }
    }

    public static function get_posts($user_id, $lastpostid) {
        $database = new Database;
        $user = trim(strip_tags(stripslashes($user_id)));
        $friends = Database::select("SELECT * FROM friends WHERE sent_by='{$user}' AND accepted='1' OR rec_by='{$user}' AND accepted='1'");
        $fetch = $friends->fetchAll();
        $j = 0;
        foreach ($fetch as $row) {
            if ($row['sent_by'] === $user) {
                $query[$j] = $row['rec_by'];
            } else {
                $query[$j] = $row['sent_by'];
            }
            $j++;
        }
        if ($friends->rowCount() !== 0 && $lastpostid === "") {
            for ($i = 0; $i < $friends->rowCount(); $i++) {
                $query1 = Database::select("SELECT * FROM posts WHERE by_user='{$query[$i]}' OR by_user='{$user}' ORDER BY date desc LIMIT 10");
            }
        } else if ($friends->rowCount() !== 0 && $lastpostid !== "") {
            $k = 0;
            foreach ($query as $row1) {
                $query1[$k] = Database::select("SELECT * FROM posts WHERE by_user='{$row1}' AND p_id <='{$lastpostid}' ORDER BY date desc");
                $k++;
            }
        } else {
            $query1 = null;
        }
        return $query1;
    }
        public static function get_posts_page($page_id, $lastpostid) {
        $user = trim(strip_tags(stripslashes($page_id)));
        $friends = Database::select("SELECT * FROM followers WHERE page='{$user}' AND following='1'");
        $fetch = $friends->fetchAll();
        foreach ($fetch as $row) {
                $query[] = $row['follower'];            
        }
        if (count($query) !== 0 && $lastpostid === "") {
            foreach ($query as $row1) {
                $query1 = Database::select("SELECT * FROM posts WHERE (by_user='{$row1}' OR by_user='{$user}') AND to_user='{$user}' AND type_to='1' ORDER BY date desc LIMIT 10");
            }
           
        } else if ($friends->rowCount() !== 0 && $lastpostid !== "") {
            foreach ($query as $row1) {
                $query1 = Database::select("SELECT * FROM posts WHERE by_user='{$row1}' AND p_id <='{$lastpostid}' ORDER BY date desc");
            }
        } else {
            $query1 = null;
        }
        return $query1;
    }

    public static function pluralize($count, $text) {
        return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
    }

    public static function timedisplay($time) {
        $times = date_create($time);
        $interval = date_create('now')->diff($times);
        $suffix = ( $interval->invert ? ' ago' : '' );
        if ($v = $interval->y >= 1) {
            return Posting::pluralize($interval->y, 'year') . $suffix;
        }
        if ($v = $interval->m >= 1) {
            return Posting::pluralize($interval->m, 'month') . $suffix;
        }
        if ($v = $interval->d >= 1) {
            return Posting::pluralize($interval->d, 'day') . $suffix;
        }
        if ($v = $interval->h >= 1) {
            return Posting::pluralize($interval->h, 'hour') . $suffix;
        }
        if ($v = $interval->i >= 1) {
            return Posting::pluralize($interval->i, 'minute') . $suffix;
        }
        return Posting::pluralize($interval->s, 'second') . $suffix;
    }

    public static function postcount($user) {
        $query = Database::select("SELECT * FROM posts WHERE by_user='{$user}'");
        $value = $query->rowCount();
        return $value;
    }

    public static function add_user($user, $adduser) {
        $userby = Database::clean($user);
        $userto = Database::clean($adduser);
        $query = Database::select("SELECT * FROM friends WHERE (sent_by='{$userby}' OR rec_by='{$userby}') AND (sent_by='{$userto}' OR rec_by='{$userto}')");
        if ($query->rowCount() == 0) {
            $array = ['', $userby, $userto, '0', '0', '0'];
            $database = Database::insert("friends", $array);
            $array1 = ['',$userto,$userby, 4, 0, 3, date("y:m:d h:i:s")];
            Database::insert("notifications", $array1);
            if ($database->rowCount() != 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
   

}

?>