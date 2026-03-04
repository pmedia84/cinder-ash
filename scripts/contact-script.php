<?php

/**
 * Script for processing the contact form and sending notification emails to admins
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mailer/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mailer/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mailer/Exception.php';

include("../email_settings.php");

header('Content-Type: application/json');

$response = [];

if (isset($_POST['token']) && $_POST['token'] != '') {

    $site_key   = '6LeRdqkkAAAAAHn11l-i3DDK9vgpi10iULGTpMHT';
    $secret_key = '6LeRdqkkAAAAADPOqG_qKv0GgReqhRMgBi9RzTl3';

    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['token']);
    $verify_data    = json_decode($verifyResponse, true);
    $score          = $verify_data['score'];

    if ($score >= 0.7) {

        // Sanitise inputs
        $visitor_name    = filter_var(trim($_POST['visitor_name']    ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $visitor_email   = filter_var(trim($_POST['visitor_email']   ?? ''), FILTER_SANITIZE_EMAIL);
        $visitor_phone   = filter_var(trim($_POST['visitor_phone']   ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $visitor_message = filter_var(trim($_POST['visitor_message'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);

        // Validate required fields
        if ($visitor_name === '') {
            echo json_encode(['success' => false, 'message' => 'Please enter your name.']);
            exit();
        }
        if (!filter_var($visitor_email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
            exit();
        }
        if ($visitor_phone === '') {
            echo json_encode(['success' => false, 'message' => 'Please enter your phone number.']);
            exit();
        }
        if ($visitor_message === '') {
            echo json_encode(['success' => false, 'message' => 'Please enter a message.']);
            exit();
        }

        $subject = 'New Contact Form Message - ' . $visitor_name;

        $body = '
        <div style="background-color:#a67d6e; padding:16px; font-family:sans-serif;">
            <h1 style="text-align:center; color:white;">New Contact Form Message</h1>
            <div style="background-color:#ffffff; padding:16px; border:10px solid #F2F2F2; border-radius:10px;">
                <h2 style="margin-top:0;">Contact Details</h2>
                <p style="border-bottom:1px solid #eee;"><strong>Name:</strong> ' . $visitor_name . '</p>
                <p style="border-bottom:1px solid #eee;"><strong>Email:</strong> ' . $visitor_email . '</p>
                <p style="border-bottom:1px solid #eee;"><strong>Phone:</strong> ' . $visitor_phone . '</p>

                <h2>Message</h2>
                <p>' . nl2br($visitor_message) . '</p>
            </div>
        </div>';

        $fromserver = $username;

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Host     = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $pass;
        $mail->Port     = 25;
        $mail->From     = $from;
        $mail->FromName = $fromname;
        $mail->Sender   = $fromserver;
        $mail->Subject  = $subject;
        $mail->Body     = $body;
        $mail->IsHTML(true);
        $mail->AddAddress($email_to);

        if (!$mail->Send()) {
            echo json_encode(['success' => false, 'message' => 'Something went wrong sending your message. Please call us on 01406 258382.']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Thank you, <strong>' . $visitor_name . '</strong>! Your message has been received. We will be in touch with you very soon.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Security check failed. Please refresh the page and try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Security check failed. Please refresh the page and try again.']);
}
