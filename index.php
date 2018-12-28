<?php

date_default_timezone_set('America/Chicago');
require 'configuration/config.config.php';
  
Sessions::start_session();
if(Sessions::get("s_id") == '')
{
    Sessions::set("s_id", uniqid(true) . session_id());
}
Sessions::set('js', false);
/* Router */
if (isset($_GET['url'])) {
    $temp = filter_var($_GET['url'], FILTER_VALIDATE_URL);
    $url = explode('/', $_GET['url']);
    $file = "controllers/controller." . $url[0] . ".php";
    $libFile = "libraries/" . $url[0] . ".php";
   if($url[0] == "public_files")
   {
       if(file_exists($url[1]))
       {
           echo "haha";
           return false;
       }
   }
    if (file_exists($file)) {
        require $file;
        $controller = new $url[0];
        if (!isset($url[1]) && !isset($url[2])) {
            $controller->main();
            return false;
        } else if (isset($url[1]) && !isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}();
                return false;
            }
        } else if (isset($url[1]) && isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
                return false;
            }
        }
    } else if (file_exists($libFile)) {
        require $libFile;
        $controller = new $url[0];
        if (!isset($url[1]) && !isset($url[2])) {
            return false;
        } else if (isset($url[1]) && !isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}();
                return false;
            }
        } else if (isset($url[1]) && isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
                return false;
            }
        }
    } else {
        require 'controllers/controller.index.php';
        $index = new index;
        $index->main();
        return false;
    }
} else if (Sessions::get('uid') != "") {
    echo "hee";
    require 'controllers/controller.login.php';
    echo 'bottom';
    $index = new login;
    $index->main();
    return false;
} else {
    require 'controllers/controller.index.php';
    $index = new index;
    $index->main();
    return false;
}
?>
