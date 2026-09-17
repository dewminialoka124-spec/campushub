<?php

include "../config/connection.php";
require "../vendor/phpmailer/PHPMailer.php";
require "../vendor/phpmailer/SMTP.php";
require "../vendor/phpmailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = "";
if (isset($_POST["e"])) {
    $email = $_POST["e"];
} elseif (isset($_GET["e"])) {
    $email = $_GET["e"];
}

if (empty($email)) {
    echo ("Please Enter Your Email Address");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' ");
    $n = $rs->num_rows;

    if ($n == 1) {

        $code = uniqid();

        Database::iud("UPDATE `user` SET `verification_code` = '" . $code . "' WHERE `email` = '" . $email . "' ");

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dewminialoka124@gmail.com';
            $mail->Password   = 'xxkkqyunkqlzuqac';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('dewminialoka124@gmail.com', 'CampusHub Support');
            $mail->addReplyTo('dewminialoka124@gmail.com', 'CampusHub Support');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'CampusHub - Password Reset Verification Code';
            
            $bodyContent = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #f8bbd0; border-radius: 12px; background-color: #fffafb;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <h2 style="color: #ec407a; margin-bottom: 5px;">CampusHub</h2>
                    <p style="color: #666; margin-top: 0;">Password Reset Request</p>
                </div>
                <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #fce4ec;">
                    <p style="font-size: 15px; color: #333;">Hello,</p>
                    <p style="font-size: 15px; color: #333;">We received a request to reset the password for your CampusHub account associated with this email address.</p>
                    <p style="font-size: 15px; color: #333;">Use the verification code below to complete your password reset:</p>
                    <div style="text-align: center; margin: 25px 0;">
                        <span style="font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #d81b60; background: #fce4ec; padding: 12px 24px; border-radius: 6px; display: inline-block;">' . $code . '</span>
                    </div>
                    <p style="font-size: 13px; color: #777;">If you did not request this password reset, please ignore this email or contact support.</p>
                </div>
                <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #aaa;">
                    <p>&copy; ' . date("Y") . ' CampusHub. All rights reserved.</p>
                </div>
            </div>';

            $mail->Body    = $bodyContent;
            $mail->AltBody = "CampusHub Password Reset Verification Code: " . $code;

            $mail->send();
            echo ("success");

        } catch (Exception $e) {
            echo ("Verification code sending failed: " . $mail->ErrorInfo);
        }

    } else {
        echo ("Invalid Email Address. No account found with this email.");
    }
}
?>
