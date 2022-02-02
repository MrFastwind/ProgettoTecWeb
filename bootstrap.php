<?php

if (basename($_SERVER['SCRIPT_NAME']) == basename("bootstrap.php")) {
    header('Location: index.php');
  }

//Defines
define("IMG_DIR", "./img/");

//Load Libs
include_once("lib/autoload.php");
include_once("lib/utils/logger.php");

//Load Session
session_start();

//Define Variables
$database_connection = array(
    "servername"=>"localhost", 
    "username"=>"root",
    "password"=>"",
    "dbname"=>"e-commerce"
);

// Database Manager
$dbm = new database\DatabaseManager(...$database_connection);

// Shop Manager
$shop = new shop\Shop($dbm);
?>