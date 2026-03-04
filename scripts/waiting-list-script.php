<?php
/**
 * Script for processing the waiting list form and sending notification emails to admins
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
        $parent_name = filter_var(trim($_POST['parent_name'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $email       = filter_var(trim($_POST['email']       ?? ''), FILTER_SANITIZE_EMAIL);
        $phone       = filter_var(trim($_POST['phone']       ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $child_name  = filter_var(trim($_POST['child_name']  ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $child_dob   = filter_var(trim($_POST['child_dob']   ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $hours       = filter_var(trim($_POST['hours']       ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $start_date  = filter_var(trim($_POST['start_date']  ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $notes       = filter_var(trim($_POST['notes']       ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);

        // Days is an array of checkboxes
        $days_raw = isset($_POST['days']) && is_array($_POST['days']) ? $_POST['days'] : [];
        $days     = implode(', ', array_map(function($d) {
            return filter_var($d, FILTER_SANITIZE_SPECIAL_CHARS);
        }, $days_raw));

        // Validate required fields
        if ($parent_name === '') {
            echo json_encode(['success' => false, 'message' => 'Please enter your name.']);
            exit();
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
            exit();
        }
        if ($phone === '') {
            echo json_encode(['success' => false, 'message' => 'Please enter your phone number.']);
            exit();
        }
        if ($child_name === '') {
            echo json_encode(['success' => false, 'message' => "Please enter your child's name."]);
            exit();
        }
        if ($child_dob === '') {
            echo json_encode(['success' => false, 'message' => "Please enter your child's date of birth."]);
            exit();
        }
        if (empty($days_raw)) {
            echo json_encode(['success' => false, 'message' => 'Please select at least one day.']);
            exit();
        }
        if ($hours === '') {
            echo json_encode(['success' => false, 'message' => 'Please select the hours required.']);
            exit();
        }
        if ($start_date === '') {
            echo json_encode(['success' => false, 'message' => 'Please enter a preferred start date.']);
            exit();
        }

        // Format dates for display
        $child_dob_fmt  = date('d/m/Y', strtotime($child_dob));
        $start_date_fmt = date('d/m/Y', strtotime($start_date));

        $subject = 'New Waiting List Request - ' . $child_name . ' (' . $parent_name . ')';

        $body = '
        <div style="background-color:#a67d6e; padding:16px; font-family:sans-serif;">
            <h1 style="text-align:center; color:white;">New Waiting List Request</h1>
            <div style="background-color:#ffffff; padding:16px; border:10px solid #F2F2F2; border-radius:10px;">
                <h2 style="margin-top:0;">Parent / Guardian Details</h2>
                <p style="border-bottom:1px solid #eee;"><strong>Name:</strong> ' . $parent_name . '</p>
                <p style="border-bottom:1px solid #eee;"><strong>Email:</strong> ' . $email . '</p>
                <p style="border-bottom:1px solid #eee;"><strong>Phone:</strong> ' . $phone . '</p>

                <h2>Child Details</h2>
                <p style="border-bottom:1px solid #eee;"><strong>Child\'s Name:</strong> ' . $child_name . '</p>
                <p style="border-bottom:1px solid #eee;"><strong>Date of Birth:</strong> ' . $child_dob_fmt . '</p>

                <h2>Session Requirements</h2>
                <p style="border-bottom:1px solid #eee;"><strong>Days Required:</strong> ' . ($days ?: 'Not specified') . '</p>
                <p style="border-bottom:1px solid #eee;"><strong>Hours Required:</strong> ' . $hours . '</p>
                <p style="border-bottom:1px solid #eee;"><strong>Preferred Start Date:</strong> ' . $start_date_fmt . '</p>

                <h2>Additional Notes</h2>
                <p>' . ($notes !== '' ? $notes : '<em>None provided</em>') . '</p>
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
            echo json_encode(['success' => false, 'message' => 'Something went wrong sending your request. Please call us on 01406 258382.']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Thank you, <strong>' . $parent_name . '</strong>! Your waiting list request has been received. We will be in touch to confirm your place.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Security check failed. Please refresh the page and try again.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Security check failed. Please refresh the page and try again.']);
}
