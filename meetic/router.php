<?php
//ini_set('display_errors', 'on');
session_start();

define('ROOT',dirname(__FILE__));
define('WEBROOT','localhost');
define('DIRNAME', basename(__DIR__));


$params = $_GET['params'];
$params = explode("/", $params);
$url = $params[0];
if ($params[1] === null) {
    if (!isset($_SESSION['pseudo']))
        $action = "connexion";
    else
        $action = "index";
}
else {
    $action = $params[1];
}

require('model/database.php');
require('view/header.php');

if (file_exists("controller/". $url . ".php")) {
    include("controller/" . $url . ".php");
    $page = new $url();
    if (method_exists($url, $action)) {
        array_splice($params, 0, 2);
        call_user_func_array(array($page, $action), $params);
    }
    else
        include ("controller/error.php");
}
else if ($url === "") {
    include("controller/home.php");
    $page = new home();
    $page->$action();
}
else
    include ("controller/error.php");
require('view/footer.php');
