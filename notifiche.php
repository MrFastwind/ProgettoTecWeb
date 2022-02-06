<?php
    require_once("./bootstrap.php");

    $user = $_SESSION["User"];
    $notifications = $dbm->getRequests()->getUserNotifications($user->UserID);

    $templateParams["name"] = "notifiche_section.php";
    $templateParams["title"] = "Notifiche";

    require("./template/base.php");
?>