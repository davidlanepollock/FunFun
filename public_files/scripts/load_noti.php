<?php
date_default_timezone_set('America/Chicago');
require '../../configuration/config.config.php';
if (!$_POST['noti']) {
    die("0");
    $page = (int) $_POST['noti'];
}
if ($_POST['noti'] > 0) {
    $user =  $_POST['noti'];
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
                            <img src="/user_data/user_profile_pic/<?php echo $usern1['pro_pic']; ?>.png" width="40px" height="40px"/>
                            <text><?php echo $usern1['fname'] . ' ' . Query::not_type($ur['type']) . ' <b>' . Query::not_value($ur['value']); ?> </b></text></div></a> <?php
                    $count++;
                }
            }
        }
    }
} else
    echo 'There is no such page!';
?>
