<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    header("Location: index.php");
    exit();
}

$u = $_SESSION["u"];

$title       = $_POST["t"];
$description = $_POST["desc"];
$date    = $_POST["date"];

if (empty($title)) {
    echo ("Please add title.");
} elseif (strlen($title) > 100) {
    echo ("Title length should be less than 100 characters.");
} elseif (empty($description)) {
    echo ("Please add description.");
} elseif (empty($date)) {
    echo ("Please add date.");
} else {


    


    Database::iud("INSERT INTO `announcement`(`title`, `description`, `published_at`) 
    VALUES ('" . $title . "', '" . $description . "', '" . $date . "')");

    echo ("success");
}

?>
