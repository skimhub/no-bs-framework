<?php

error_reporting(E_ALL);
ini_set("display_errors", "On");
define("IN_ADMIN", true);

require_once("../config.php");
require_once("../includes/model.class.php");
require_once("../includes/example.class.php");
require_once("../helpers/admin_helper.class.php");

require_once("menus.php");

$db = mysqlConnect($dbhost, $dbuser, $dbpass, $dbname);
$product = new Example($db);

$admin_helper = new AdminHelper();

if (!isset($_REQUEST['menu']) || !$_REQUEST['menu']){
    $menu = "dashboard";
} else {
    $menu = preg_replace("/[^a-z0-9A-Z_\-]/", "", $_REQUEST['menu']);
}

require_once("header.php");
if (!file_exists($menu.".php")){
    print("Not implemented");
} else {
    require_once($menu.".php");
}
require_once("footer.php");