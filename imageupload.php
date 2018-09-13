<?php
date_default_timezone_set('America/Chicago');
require '/configuration/config.config.php';
if (!$_POST['postid'] || !$_POST['uid']) {
    echo "Could not connect to server";
}
if ($_POST['postid'] > 0) {
   
    return false;
} else{
    echo '<text><center>There was an error.</center></text>';
}
?>
