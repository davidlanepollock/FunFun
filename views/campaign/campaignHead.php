
<div class="menu content-full">
    <div class="menu-item">
        <?php
        $url = filter_input(INPUT_GET, 'url');
        $Furl = explode('/', $url);
        switch (strtolower($Furl[0])) {
            default : $m1 = "/home";
                $m1t = "Home";
                break;
            case "home": $m1 = "/campaign";
                $m1t = "Campaigns"; $page = "Home";
                break;
            case "ad_sets": $m1 = "/campaign";
                $m1t = "Campaigns"; $page = "Ad Sets";
                break;
            case "campaign": $m1 = "/home";
                $m1t = "Home"; $page = "Campaigns";
                break;
        }
        ?>
        <a href="<?= APP_URL; echo $m1; ?>"><?= $m1t; ?></a>
    </div>
    <div class="menu-item">
        <a href="<?= APP_URL; ?>/ad_sets">Ad Sets</a>
    </div>
    <div class="menu-item">
        Audiences
    </div>
    <div class="menu-right">
        <?= $page; ?>
    </div>
</div>