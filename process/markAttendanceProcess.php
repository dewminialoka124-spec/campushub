<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo ("You Do Not Have Permission");
} else {

    $id = $_POST["id"];

    $rs = Database::search("SELECT * FROM `registration` WHERE `id`='" . $id . "' ");

    if ($rs->num_rows != 1) {
        echo ("Registration Not Found");
    } else {

        // UPDATE operation
        Database::iud("UPDATE `registration` SET `status`='attended' WHERE `id`='" . $id . "' ");

        echo ("success");
    }
}

?>
