<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"])) {
    header("Location: index.php");
    exit();
}

$u = $_SESSION["u"];

$fname       = isset($_POST["fname"]) ? $_POST["fname"] : "";
$lname       = isset($_POST["lname"]) ? $_POST["lname"] : "";
$mobile      = isset($_POST["mobile"]) ? $_POST["mobile"] : "";
$institution = isset($_POST["institution"]) ? $_POST["institution"] : "";
$bio         = isset($_POST["bio"]) ? $_POST["bio"] : "";

// Validation & error handling
if (empty($fname)) {
    echo ("Please Enter Your First Name");
} elseif (empty($lname)) {
    echo ("Please Enter Your Last Name");
} elseif (empty($mobile)) {
    echo ("Please Enter Your Mobile Number");
} elseif (!preg_match("/^[0-1,2,4,5,6,7,8]{1}[0-9]{9}$/", $mobile)) {
    echo ("Invalid Mobile Number Format");
} elseif (empty($institution) || $institution == "0") {
    echo ("Please Select Your Institution");
} else {

    $fileName = "";

    // File upload handling
    if (isset($_FILES["profileimage"]) && $_FILES["profileimage"]["error"] == 0) {

        $file = $_FILES["profileimage"];
        $allowed = array("image/jpeg", "image/png");

        if (!in_array($file["type"], $allowed)) {
            echo ("Only JPG and PNG Images Are Allowed");
            exit();
        }

        if ($file["size"] > 2097152) {
            echo ("Image Must Be Less Than 2MB");
            exit();
        }

        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $fileName = uniqid() . "." . $extension;
        $path = "resource/profile_images/" . $fileName;

        if (!move_uploaded_file($file["tmp_name"], "../" . $path)) {
            echo ("Image Upload Failed");
            exit();
        }
    }

    // UPDATE operation
    if (empty($fileName)) {
        Database::iud("UPDATE `user` SET `fname`='" . $fname . "', `lname`='" . $lname . "', 
        `mobile`='" . $mobile . "', `insitutation_id`='" . $institution . "', `bio`='" . $bio . "' 
        WHERE `id`='" . $u["id"] . "' ");
    } else {
        Database::iud("UPDATE `user` SET `fname`='" . $fname . "', `lname`='" . $lname . "', 
        `mobile`='" . $mobile . "', `insitutation_id`='" . $institution . "', `bio`='" . $bio . "', 
        `profile_pic`='" . $fileName . "' WHERE `id`='" . $u["id"] . "' ");
    }

    // refresh the session data
    $rs = Database::search("SELECT * FROM `user` WHERE `id`='" . $u["id"] . "' ");
    $_SESSION["u"] = $rs->fetch_assoc();

    echo ("success");
}

?>
