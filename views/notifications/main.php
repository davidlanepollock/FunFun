<div class="not-head">
    <center>Notifications</center>
</div>
<div class='not-middle'>
    <?php
    $user = Database::clean(Sessions::get('uid'));
    $query = Database::select("SELECT * FROM notifications WHERE ut_id='{$user}' ORDER BY date desc");
    if ($query->rowCount() != 0) {
        foreach ($query as $ur) {
            $ush = $ur['uf_id'];
            $usern = Database::select("SELECT * FROM users WHERE id='{$ush}'");
            if ($usern->rowCount() === 1) {
                $usern1 = $usern->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class='<?php
                switch ($ur['viewed']) {
                    case 0: echo "not-in";
                        break;
                    case 1: echo "not-inv";
                        break;
                    case 2: echo "not-in";
                        break;
                }
                ?>'>        
                    <img src="/user_data/user_profile_pic/<?php echo $usern1['pro_pic']; ?>.png" width="60px" height="60px"/><text><?php echo $usern1['fname'] . ' ' . Query::not_type($ur['type']) . ' <b>' . Query::not_value($ur['value']); ?></b></text>
                    <?php
                    if ($ur['type'] == 4 && $ur['value'] == 3) {
                        $but = Database::select("SELECT * FROM friends WHERE f_id='{$ur['ref']}'");
                        $butr = $but->fetch(PDO::FETCH_ASSOC);
                        if ($butr['accepted'] === 0) {
                            echo '<button class="acceptr" id="' . $ur['ref'] . '">Decline</button>' . '<button class="acceptr" id="' . $ur['ref'] . '">Accept</button>';
                        } else if ($butr['accepted'] === 1) {
                            echo "<div class='response'>Accepted request</div>";
                        } else if ($butr['accepted'] === 2) {
                            echo "<div class='response'>" . $butr['accepted'] . "Declined request</div>";
                        }
                    }
                }
                ?>
            </div>
        <?php
        }
    }
    ?>
</div>