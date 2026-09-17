<?php

include "../config/connection.php";

$fname       = isset($_POST["f"]) ? $_POST["f"] : "";
$lname       = isset($_POST["l"]) ? $_POST["l"] : "";
$email       = isset($_POST["e"]) ? $_POST["e"] : "";
$password    = isset($_POST["p"]) ? $_POST["p"] : "";
$mobile      = isset($_POST["m"]) ? $_POST["m"] : "";
$gender      = isset($_POST["g"]) ? $_POST["g"] : "";
$institution = isset($_POST["i"]) ? $_POST["i"] : "";


if (empty($fname)) {
    echo ("Please Enter Your First Name");
} elseif (strlen($fname) > 20) {
    echo ("First Name must be less than 20 characters");
} elseif (empty($lname)) {
    echo ("Please Enter Your Last Name");
} elseif (strlen($lname) > 30) {
    echo ("Last Name must be less than 30 characters");
} elseif (empty($email)) {
    echo ("Please Enter Your Email");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Format");
} elseif (empty($password)) {
    echo ("Please Enter Your Password");
} elseif (strlen($password) < 5 || strlen($password) > 15) {
    echo ("Password must Contain 5 to 15 characters");
} elseif (empty($mobile)) {
    echo ("Please Enter Your Mobile Number");
} elseif (!preg_match("/^[0-1,2,4,5,6,7,8]{1}[0-9]{9}$/", $mobile)) {
    echo ("Invalid Mobile Number Format");
} elseif (empty($gender) || $gender == "0") {
    echo ("Please Select Your Gender");
} elseif (empty($institution) || $institution == "0") {
    echo ("Please Select Your Institution");
} else {

    // DB Search
    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' ");

    if ($rs->num_rows > 0) {
        echo ("User Already Exists with this email, Use Another Email");
    } else {

        // Date & Time
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user`(`email`, `fname`, `lname`, `password`, `mobile`, `gender`, `insitutation_id`, `role`, `status`, `joined_date`) 
        VALUES ('" . $email . "', '" . $fname . "', '" . $lname . "', '" . $password . "', '" . $mobile . "', '" . $gender . "', '" . $institution . "', 'student', '1', '" . $date . "')");

        echo "success";
    }
}

?>
