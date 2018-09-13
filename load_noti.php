<?php
date_default_timezone_set('America/Chicago');
require '/configuration/config.config.php';
if (!$_POST['noti']) {
    echo "Could not connect to server";
    $page = (int) $_POST['noti'];
}
if ($_POST['noti'] > 0) {
    $user = $_POST['noti'];
    $count = 0;
    $query = Database::select("SELECT * FROM notifications WHERE ut_id='{$user}' ORDER BY date desc");
    if ($query->rowCount() != 0) {
        foreach ($query as $ur) {
            if ($count === 5) {
                break;
            } else {
                $ush = $ur['uf_id'];
                $usern = Database::select("SELECT * FROM users WHERE id='{$ush}'");
                if ($usern->rowCount() === 1) {
                    $usern1 = $usern->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <a class="link" href="/<?php echo Query::not_value_links($ur['value']) . '/' . $ur['ref']; ?>">
                        <input type='hidden' name='n_id' id='n_id' value='<?= $ur['n_id']; ?>' />
                        <div class="<?php
                        switch ($ur['viewed']) {
                            case 0: echo "notif";
                                break;
                            case 1: echo "notifviewed";
                                break;
                            case 2: echo "notif";
                                break;
                        }
                        ?>">
                            <img src="<?= APP_URL; ?>/user_data/user_profile_pic/<?php echo $usern1['pro_pic']; ?>.png" width="40px" height="40px"/>
                            <text><?= $usern1['fname'] . ' ' . Query::not_type($ur['type']) . ' <b>' . Query::not_value($ur['value']); ?> </b></text>
                            <div class="nviewed" id="nviewed"></div>
                        </div></a> <?php
                    $count++;
                }
            }
        }
        
    } ?>
    <div class="bottom"><a href="/notifications/<?php echo Sessions::get('uid')*Query::specialkey(); ?>">View all (<?php echo $query->rowCount(); ?>)</a></div>
   <?php return false;
} else
    echo 'There is no such page!';
?>
