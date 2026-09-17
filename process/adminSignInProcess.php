<?php

session_start();
include "../config/connection.php";

$email    = isset($_POST["e"]) ? $_POST["e"] : "";
$password = isset($_POST["p"]) ? $_POST["p"] : "";
$remember = isset($_POST["r"]) ? $_POST["r"] : "false";

if (empty($email)) {
    echo ("Please Enter Your Email");
} elseif (empty($password)) {
    echo ("Please Enter Your Password");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "' ");

    if ($rs->num_rows == 1) {
        $d = $rs->fetch_assoc();

        if ($d["role"] != "admin") {
            echo ("Access Denied: This account is not registered as an administrator.");
            exit();
        }

        if ($d["status"] == 1) {
            // Save admin session
            $_SESSION["u"] = $d;

            // Remember me handling
            if ($remember == "true") {
                setcookie("admin_email", $email, time() + (60 * 60 * 24 * 365));
                setcookie("admin_password", $password, time() + (60 * 60 * 24 * 365));
            } else {
                setcookie("admin_email", "", -1);
                setcookie("admin_password", "", -1);
            }

            echo ("success");
        } else {
            echo ("Your Admin Account is Deactivated. Please Contact System Administrator.");
        }
    } else {
        echo ("Invalid Admin Email or Password");
    }
}

?>
