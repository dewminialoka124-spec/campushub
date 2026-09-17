<?php

include "../config/connection.php";

$name    = $_POST["n"];
$email   = $_POST["e"];
$subject = $_POST["s"];
$message = $_POST["m"];

// Validation & error handling
if (empty($name)) {
    echo ("Please Enter Your Name");
} elseif (empty($email)) {
    echo ("Please Enter Your Email");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Format");
} elseif (empty($subject)) {
    echo ("Please Enter A Subject");
} elseif (empty($message)) {
    echo ("Please Enter Your Message");
} elseif (strlen($message) > 500) {
    echo ("Message must be less than 500 characters");
} else {

    // Date & Time
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    // INSERT operation
    Database::iud("INSERT INTO `contact_message`(`name`, `email`, `subject`, `message`, `status`, `sent_date`) 
    VALUES ('" . $name . "', '" . $email . "', '" . $subject . "', '" . $message . "', 'new', '" . $date . "')");

    echo ("success");
}

?>
