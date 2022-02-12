<?php
    require_once("./bootstrap.php");

    $shop->getUserManager()->logOut();

    header("location: /index.php");
?>