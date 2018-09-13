<html>
    <head>
        <meta charset='UTF-8'>        
        <meta name='keywords' content=''>
        <meta name='description' content=''>
        <meta name='copyright' content='<?= APP_NAME ?>'>
        <meta name='robots' content='index,follow'>
        <meta name='Classification' content='Business'>
        <meta name='owner' content=''>
        <meta name='url' content='<?= APP_URL; ?>'>
        <title><?php echo $this->title; ?></title>
        <link rel='stylesheet' type='text/css' href='<?= APP_URL; ?>/public_files/css/<?php echo $this->stylesheet; ?>' />
        <link rel='stylesheet' type='text/css' href='<?= APP_URL; ?>/public_files/css/default.css' />
        <link rel='stylesheet' type='text/css' href='<?= APP_URL; ?>/public_files/css/notifications.css' />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src='<?= APP_URL; ?>/public_files/javascript/header.js'></script>
        <script type="text/javascript">
            javascriptTest();
        </script>
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel='stylesheet' type='text/css' href='<?= APP_URL ?>/public_files/css/header.css' />
    </head>
    <body>
        <div class="header-main">
            <div class="header-logo">
                <h3><?= APP_NAME; ?></h3>
            </div>
            <div class="header-left">
                <div class="header-search"><input type="text" placeholder="Search MSD Merch Inventory" tabindex="0"><button class="header-search-button"><img src="<?= APP_URL; ?>/public_files/includes/i16.png" width="20px" height="20px"></button></div>
                <!-- <div class="header-search" role="combobox" data-text="Search <?= APP_NAME; ?>" aria-label="Search <?= APP_NAME; ?>" tabindex="0" contenteditable="true"></div> -->
            </div>
            <div class="header-right">
                <div class="header-links">
                    <ul>
                        <?php if (Sessions::get('uid')) { ?>
                        <a href="<?= APP_URL; ?>/home"><li>Home</li></a>
                        <a href="<?= APP_URL; ?>/profile"><li>Profile</li></a>
                        <a onclick="more();"><li>More</li></a>
                        <?php } else { ?>
                            <a href="<?= APP_URL; ?>/login"><li>Login</li></a>
                            <a href="<?= APP_URL; ?>/signup"><li>Register</li></a>
                            <a href="<?= APP_URL; ?>/login"><li>About</li></a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>

        
        