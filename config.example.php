<?php

date_default_timezone_set("Europe/London");
header('Content-Type:text/html; charset=UTF-8');
ini_set('default_charset', 'UTF-8');

$dbhost = "";
$dbuser = "";
$dbpass = "";
$dbname = "";

$basepath = "";
$baseurl = "";

function mysqlConnect($dbhost, $dbuser, $dbpass, $dbname){
    $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    if ($db->connect_errno){
        print("can't connect to database\n");
        exit();
    }
    
    $db->query("SET NAMES 'utf8'");
    $db->set_charset("utf8");

    return $db;
}
