<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"])) {
    echo ("Please Sign In First");
} else {

    $u = $_SESSION["u"];
    $id = $_POST["id"];

    // check the registration belongs to the logged user
    $rs = Database::search("SELECT * FROM `registration` 
    WHERE `id`='" . $id . "' AND `user_id`='" . $u["id"] . "' ");

    if ($rs->num_rows != 1) {
        echo ("Registration Not Found");
    } else {

        // UPDATE operation
        Database::iud("UPDATE `registration` SET `status`='cancelled' WHERE `id`='" . $id . "' ");

        echo ("success");
    }
}

?>
