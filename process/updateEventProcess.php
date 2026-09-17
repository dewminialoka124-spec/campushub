<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    header("Location: index.php");
    exit();
}

$id          = $_POST["id"];
$title       = $_POST["title"];
$description = $_POST["description"];
$category    = $_POST["category"];
$location    = $_POST["location"];
$eventDate   = $_POST["event_date"];
$capacity    = $_POST["capacity"];
$status      = $_POST["status"];

// Validation & error handling
if (empty($title)) {
    echo ("Please Enter The Event Title");
} elseif (empty($description)) {
    echo ("Please Enter The Event Description");
} elseif (empty($location)) {
    echo ("Please Enter The Venue");
} elseif (empty($eventDate)) {
    echo ("Please Select The Event Date And Time");
} elseif (empty($capacity) || $capacity < 1) {
    echo ("Capacity must be a number greater than zero");
} else {

    $fileName = "";

    // File upload handling
    if (isset($_FILES["eventimage"]) && $_FILES["eventimage"]["error"] == 0) {

        $file = $_FILES["eventimage"];
        $allowed = array("image/jpeg", "image/png");

        if (!in_array($file["type"], $allowed)) {
            echo ("Only JPG and PNG Images Are Allowed");
            exit();
        }

        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $fileName = uniqid() . "." . $extension;

        if (!move_uploaded_file($file["tmp_name"], "../resource/event_images/" . $fileName)) {
            echo ("Image Upload Failed");
            exit();
        }
    }

    $eventDate = str_replace("T", " ", $eventDate) . ":00";

    // UPDATE operation
    if (empty($fileName)) {
        Database::iud("UPDATE `event` SET `title`='" . $title . "', `description`='" . $description . "', 
        `category`='" . $category . "', `location`='" . $location . "', `event_date`='" . $eventDate . "', 
        `max_capacity`='" . $capacity . "', `status`='" . $status . "' WHERE `id`='" . $id . "' ");
    } else {
        Database::iud("UPDATE `event` SET `title`='" . $title . "', `description`='" . $description . "', 
        `category`='" . $category . "', `location`='" . $location . "', `event_date`='" . $eventDate . "', 
        `max_capacity`='" . $capacity . "', `status`='" . $status . "', `image`='" . $fileName . "' 
        WHERE `id`='" . $id . "' ");
    }

    echo ("success");
}

?>
