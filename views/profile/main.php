<?php
if ($this->account_status == 2) {
    header("location: " . APP_URL . "index");
} else if ($this->account_status == 3) {
    echo "<center><h1>Sorry but this user has been blocked</h1></center>";
    return false;
}
?>
<script src='<?php echo APP_URL; ?>public_files/javascript/profile.js'></script>
<div class='profile_banner'></div>
<div class='profile-up-head'>
    <div class='profile-user-info'>
        <IMG class="propicpage" src='<?= APP_URL; ?>user_data/user_profile_pic/<?= $this->propic; ?>.png' />
        <div class='info-middle'>
            <h3><?= $this->firstname . ' ' . $this->lastname; ?></h3>
            <p><?= $this->bio; ?></p>
        </div>
    </div>
</div>
<div class="columns">
    <div class='left-column'>
        <div class='sidebar-element'>
            <div class='sidebar-head'>
                <h4>About <?= $this->firstname; ?></h4>
            </div>
            <div class='inner-sidebar'>
                <div class='item'><b>Username: </b> <?= $this->username; ?><br /></div>
                <div class='item'><b>Bio: </b> <?= $this->bio; ?></div>
            </div>
        </div>
        <div class="sidebar-element">
            <div class="sidebar-head">
                <h4>Interactions</h4>
                <ul>
                    <li>Add</li>
                    <li>Message</li>
                    <li>More</li>
                </ul>
            </div>
        </div>
        <div class='sidebar-element'>
            <div class='sidebar-head'>
                <?php echo $this->firstname; ?>'s photos
            </div>
            <div class='inner-sidebar'>
                <center><h3>No Photos</h3></center>
            </div>
        </div>
    </div>
    <div class="middlecon" id="middlecon">
        <form action='' method='post' onSubmit='return false;' id='postForm'>
            <div class="posting" id="posting">
                <textarea placeholder="What are you doing?" class="postarea" id="postarea" onclick="posting();" ></textarea>
                <input type='hidden' name='profile-uid' id='profile-uid' value='<?php
                $id = Sessions::get('uid');
                $type = Sessions::get('type');
                echo $id;
                ?>' />
                <input type='hidden' name='profile-username' id='profile-username' value='<?= Query::username($id, $type); ?>' />
                <input type='hidden' name='profile-ptype' id='profile-btype' value='<?= Sessions::get('type'); ?>' />
                <input type='hidden' name='profile-ttype' id='profile-ttype' value='1' />
            </div>
            <div class="toolbar" id="toolbar">
                <li><img src="" height="20px" width="20px"/> Add Photo</li>
                <li><img src="" height="20px" width="20px"/> Tag Friend</li>        
                <li><img src="" height="20px" width="20px"/> Tag Crew</li>
                <li><img src="" height="20px" width="20px"/> Promote</li>
                <div class="sub" id="submitpost">
                    <button value="Post" type="submit" width="120px" >Post</button>            
                </div>
            </div>
        </form>
        <div class="spacer" id="spacer">

        </div>
        <div class="content" id="content">
            <div class="newpost"></div>
            <?php
            $query = Posting::get_posts($this->userid, '');
            if ($query !== null) {
                foreach ($query as $row) {
                    $pageid = $row['type_by'];
                    $db = Query::post_type($pageid);
                    $userinfo = Database::select("SELECT * FROM '{$db}' WHERE id='{$row['by_user']}'");
                    $users = $userinfo->fetchAll();
                    foreach ($users as $userpost) {
                        ?>
                        <div class="posts" onclick="postdef('<?php echo $row['p_id']; ?>');">
                            <input type='hidden' name='postid' id='postid' value='<?php echo $row['p_id']; ?>' />
                            <div class="upropic">
                                <img src="<?= APP_URL; ?>user_data/user_profile_pic/<?php echo $userpost['pro_pic']; ?>.png" width="40px" height="40px"/>
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
                }
                ?>
                <img src="<?= APP_URL; ?>public_files/includes/loading.gif" class="loading1" id="loading">
                <div class="loadingtext1">Gathering posts</div>
                <?php
            } else {
                ?>
                <div class="posts">

                    <text><center>There are no posts to be displayed.</center></text>

                </div>
<?php } ?>
        </div></div>
    
    <div class='right-column'>
        <div class='sidebar-element'>
            <?php
            $user = Sessions::get('uid');
            $profile = $this->userid;
            if (Sessions::get('uid') != "" && $user != $profile) {
                $query = Database::select("SELECT * FROM friends WHERE (sent_by='{$user}' OR rec_by='{$user}') AND (sent_by='{$profile}' OR rec_by='{$profile}')");
                if ($query->rowCount() != 1) {
                    ?>
                    <button id="add" value="<?php echo $profile; ?>" onclick="adduser();">Add As Friend</button>
                <?php } else { ?>
                    <button>Request Sent</button>
                <?php } ?>
                <button>Send Message</button>
                <button>Report</button>
            <?php } else if ($user === $profile) { ?>
                <li><span>Friends</span></li>
                <li><span>Activity</span></li>
                <li><span>Send Message</span></li>       
            <?php } ?>
        </div>

    </div>
</div>

