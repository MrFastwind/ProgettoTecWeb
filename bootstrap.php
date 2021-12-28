<?php
session_start();

//Defines
define("IMG_DIR", "./img/");

//Load Libs
include_once("lib/autoload.php");
//LoadClasses();

//Load other files


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