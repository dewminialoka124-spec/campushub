<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo ("You Do Not Have Permission");
} else {

    $id = $_POST["id"];

    $rs = Database::search("SELECT * FROM `event` WHERE `id`='" . $id . "' ");

    if ($rs->num_rows != 1) {
        echo ("Event Not Found");
    } else {

        // DELETE operation
        Database::iud("DELETE FROM `event` WHERE `id`='" . $id . "' ");

        echo ("success");
    }
}

?>
