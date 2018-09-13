<?php
date_default_timezone_set('America/Chicago');
require '/configuration/config.config.php';
if (!$_POST['postid'] || !$_POST['uid']) {
    echo "Could not connect to server";
}
else if ($_POST['postid'] !== 0) {
    $user = $_POST['uid'];
    $post = $_POST['postid'];
    $query = Posting::get_posts($user, $post);
    if ($query !== null) {
        foreach ($query as $row) {
            $userinfo = Database::select("SELECT * FROM users WHERE id='{$row['by_user']}'");
            $users = $userinfo->fetchAll();
            foreach ($users as $userpost) {
                ?>
                <div class="posts" onclick="postdef('<?php echo $row['p_id']; ?>');">
                    <input type='hidden' name='postid' id='postid' value='<?php echo $row['p_id']; ?>' />
                    <div class="upropic">
                        <img src="/user_data/user_profile_pic/<?php echo $userpost['pro_pic']; ?>.png" width="40px" height="40px"/>
                    </div>
                    <div class="name">
                        <a href="/profile/<?php echo $userpost['username']; ?>" ><?php echo $userpost['fname'] . " " . $userpost['lname']; ?></a>
                    </div>
                    <div class="username">
                        @<?php echo $userpost['username']; ?>
                    </div>
                    <div class="time">
                        <?php echo posting::timedisplay($row['date']); ?>
                    </div>
                    <div class="contentb" >
                        <?php echo $row['body']; ?>
                    </div>
                    <div class="postdef" id="<?php echo "postdef" . $row['p_id']; ?>">
                        <div class="uinput">
                            
                        </div>
                    </div>
                </div>
                <?php
            }
        } ?>
        <div class="posts">

            <text><center>There are no more posts to display</center></text>

        </div>
<?php
    } else {
        ?>
        <div class="posts">

            <text><center>There are no posts to be displayed.</center></text>

        </div>
    <?php }  return false;
} else{
    ?><text><center>There was an error.</center></text> <?php
}
?>
