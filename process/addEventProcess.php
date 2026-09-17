<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"]) || $_SESSION["u"]["role"] != "admin") {
    header("Location: index.php");
    exit();
}

$u = $_SESSION["u"];

$title       = $_POST["title"];
$description = $_POST["description"];
$category    = $_POST["category"];
$location    = $_POST["location"];
$eventDate   = $_POST["event_date"];
$capacity    = $_POST["capacity"];

// Validation & error handling
if (empty($title)) {
    echo ("Please Enter The Event Title");
} elseif (strlen($title) > 100) {
    echo ("Title must be less than 100 characters");
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

        if ($file["size"] > 5242880) {
            echo ("Image Must Be Less Than 5MB");
            exit();
        }

        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $fileName = uniqid() . "." . $extension;

        if (!move_uploaded_file($file["tmp_name"], "../resource/event_images/" . $fileName)) {
            echo ("Image Upload Failed");
            exit();
        }
    }

    // Date & Time
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $eventDate = str_replace("T", " ", $eventDate) . ":00";

    // INSERT operation
    Database::iud("INSERT INTO `event`(`title`, `description`, `category`, `location`, `event_date`, `max_capacity`, `image`, `status`, `created_by`, `created_date`) 
    VALUES ('" . $title . "', '" . $description . "', '" . $category . "', '" . $location . "', '" . $eventDate . "', '" . $capacity . "', '" . $fileName . "', 'published', '" . $u["id"] . "', '" . $date . "')");

    echo ("success");
}

?>
