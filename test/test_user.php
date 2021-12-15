<?php
include ("../bootstrap.php");

$testUser=(int)1;
//var_dump($dbh->getUserById($testUser));
$factory=$dbm->getFactory();
$user = $factory->getUser($testUser);

var_dump($user);

$productList = $factory->getProducts(0,5);

var_dump($productList);

?>