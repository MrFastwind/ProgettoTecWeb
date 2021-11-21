<?php
include ("../bootstrap.php");

$testUser=(int)1;
//var_dump($dbh->getUserById($testUser));
$factory=new database\DatabaseObjectFactory($dbh);

$user = $factory->getUser($testUser);

var_dump($user);

?>