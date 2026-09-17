<?php

session_start();
include "../config/connection.php";

if (!isset($_SESSION["u"])) {
    header("Location: index.php");
    exit();
}

$u = $_SESSION["u"];

$eventId = $_POST["event"];
$caption = $_POST["caption"];

// Validation & error handling
if (empty($caption)) {
    echo ("Please Enter A Caption");
    exit();
}

if (!isset($_FILES["mediafile"]) || $_FILES["mediafile"]["error"] != 0) {
    echo ("Please Select A Photo To Upload");
    exit();
}

$file = $_FILES["mediafile"];
$allowed = array("image/jpeg", "image/png");

if (!in_array($file["type"], $allowed)) {
    echo ("Only JPG and PNG Images Are Allowed");
    exit();
}

if ($file["size"] > 5242880) {
    echo ("Photo Must Be Less Than 5MB");
    exit();
}

$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
$fileName = uniqid() . "." . $extension;
$path = "resource/gallery/" . $fileName;

if (move_uploaded_file($file["tmp_name"], "../" . $path)) {

    // Date & Time
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    // INSERT operation
    if (empty($eventId)) {
        Database::iud("INSERT INTO `media`(`event_id`, `user_id`, `filename`, `file_path`, `caption`, `media_type`, `uploaded_date`) 
        VALUES (NULL, '" . $u["id"] . "', '" . $fileName . "', '" . $path . "', '" . $caption . "', 'image', '" . $date . "')");
    } else {
        Database::iud("INSERT INTO `media`(`event_id`, `user_id`, `filename`, `file_path`, `caption`, `media_type`, `uploaded_date`) 
        VALUES ('" . $eventId . "', '" . $u["id"] . "', '" . $fileName . "', '" . $path . "', '" . $caption . "', 'image', '" . $date . "')");
    }

    echo ("success");
} else {
    echo ("Photo Upload Failed");
}

?>
