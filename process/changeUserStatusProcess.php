<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    echo ("You Do Not Have Permission");
} else {

    $id = $_POST["id"];

    $rs = Database::search("SELECT * FROM `user` WHERE `id`='" . $id . "' ");

    if ($rs->num_rows != 1) {
        echo ("Student Not Found");
    } else {

        $d = $rs->fetch_assoc();

        if ($d["status"] == 1) {
            Database::iud("UPDATE `user` SET `status`='0' WHERE `id`='" . $id . "' ");
        } else {
            Database::iud("UPDATE `user` SET `status`='1' WHERE `id`='" . $id . "' ");
        }

        echo ("success");
    }
}

?>
