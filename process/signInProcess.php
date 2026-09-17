<?php

session_start();
include "../config/connection.php";


$email = $_POST["e"];
$password = $_POST["p"];


if (empty($email)) {
    echo ("Please Enter Your Email");
} elseif (empty($password)) {
    echo ("Please Enter Your Password");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' 
    AND `password`='" . $password . "' ");

    if ($rs->num_rows == 1) {
        $d = $rs->fetch_assoc();

        if ($d["status"] == 1) {
            // save all details as logged user
            $_SESSION["u"] = $d;

            // check remember me option
            if ($_POST["r"] == "true") {
                // set cookie
                setcookie("email", $email, time() + (60 * 60 * 24 * 365));
                setcookie("password", $password, time() + (60 * 60 * 24 * 365));
            } else {
                // remove cookie
                setcookie("email", "", -1);
                setcookie("password", "", -1);
            }

            echo ("success");
        } else {
            echo ("Your Account is Deactivated, Please Contact Admin");
        }
    } else {
        echo ("Invalid Email or Password");
    }
}

?>
