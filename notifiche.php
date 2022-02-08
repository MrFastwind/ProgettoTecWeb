<?php
    require_once("./bootstrap.php");

    $user = $_SESSION["User"];
    $notifications = $dbm->getRequests()->getUserNotifications($user->UserID);
    $notifications = array_reverse($notifications);

    $templateParams["name"] = "notifiche_section.php";
    $templateParams["title"] = "Notifiche";

    require("./template/base.php");
?>