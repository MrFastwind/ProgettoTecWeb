<?php
session_start();

//Defines
define("IMG_DIR", "./img/");

//Load Libs
include_once("lib/autoload.php");
//LoadClasses();

//Load other files


//Define Variables
$dbh = new database\DatabaseHelper("localhost", "root", "", "e-commerce");
?>