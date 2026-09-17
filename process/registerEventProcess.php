<?php

session_start();
include "../config/connection.php";

// Error handling : only logged users can register
if (!isset($_SESSION["u"])) {
    echo ("Please Sign In First");
} else {

    $eventId = $_POST["ev"];
    $userId  = $_POST["u"];
    $name    = $_POST["n"];
    $email   = $_POST["e"];
    $mobile  = $_POST["m"];
    $note    = $_POST["no"];

    if (empty($name)) {
        echo ("Please Enter Your Full Name");
    } elseif (empty($email)) {
        echo ("Please Enter Your Email");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email Format");
    } elseif (empty($mobile)) {
        echo ("Please Enter Your Mobile Number");
    } elseif (!preg_match("/^[0-1,2,4,5,6,7,8]{1}[0-9]{9}$/", $mobile)) {
        echo ("Invalid Mobile Number Format");
    } else {

        // check the event
        $es = Database::search("SELECT * FROM `event` WHERE `id`='" . $eventId . "' ");

        if ($es->num_rows != 1) {
            echo ("Event Not Found");
        } else {
            $e = $es->fetch_assoc();

            // check duplicate registration
            $rs = Database::search("SELECT * FROM `registration` 
            WHERE `event_id`='" . $eventId . "' AND `user_id`='" . $userId . "' AND `status`='registered' ");

            if ($rs->num_rows > 0) {
                echo ("You Have Already Registered For This Event");
            } else {

                // check capacity
                $cs = Database::search("SELECT COUNT(*) AS `total` FROM `registration` 
                WHERE `event_id`='" . $eventId . "' AND `status`='registered' ");
                $c = $cs->fetch_assoc();

                if ($c["total"] >= $e["max_capacity"]) {
                    echo ("Sorry, This Event Is Full");
                } else {

                    // Date & Time
                    $d = new DateTime();
                    $tz = new DateTimeZone("Asia/Colombo");
                    $d->setTimezone($tz);
                    $date = $d->format("Y-m-d H:i:s");

                    Database::iud("INSERT INTO `registration`(`event_id`, `user_id`, `full_name`, `email`, `mobile`, `note`, `status`, `registered_date`) 
                    VALUES ('" . $eventId . "', '" . $userId . "', '" . $name . "', '" . $email . "', '" . $mobile . "', '" . $note . "', 'registered', '" . $date . "')");

                    echo ("success");
                }
            }
        }
    }
}

?>
