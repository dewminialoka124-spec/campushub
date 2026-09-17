<?php

include "../config/connection.php";

$email    = isset($_POST["e"]) ? $_POST["e"] : "";
$newPass  = isset($_POST["n"]) ? $_POST["n"] : "";
$rePass   = isset($_POST["r"]) ? $_POST["r"] : "";
$vcode    = isset($_POST["c"]) ? $_POST["c"] : "";

if (empty($email)) {
    echo ("Please Enter Your Email Address");
} elseif (empty($newPass)) {
    echo ("Please Enter Your New Password");
} elseif (strlen($newPass) < 5 || strlen($newPass) > 20) {
    echo ("Password must contain between 5 and 20 characters");
} elseif (empty($rePass)) {
    echo ("Please Re-type Your New Password");
} elseif ($newPass != $rePass) {
    echo ("Passwords do not match");
} elseif (empty($vcode)) {
    echo ("Please Enter The Verification Code");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' AND `verification_code` = '" . $vcode . "' ");
    $n = $rs->num_rows;

    if ($n == 1) {
        Database::iud("UPDATE `user` SET `password` = '" . $newPass . "', `verification_code` = NULL WHERE `email` = '" . $email . "' ");
        echo ("success");
    } else {
        echo ("Invalid Email or Verification Code");
    }
}
?>
