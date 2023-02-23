<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mailer/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mailer/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mailer/Exception.php';
/// Define who the emails get sent to from forms filled out
include("../email_settings.php");
$response="";
if (isset($_POST['token']) && $_POST['token'] >NULL){
   //Recaptcha security test
   $site_key = '6LeRdqkkAAAAAHn11l-i3DDK9vgpi10iULGTpMHT'; //site key from recaptcha admin
   $secret_key = '6LeRdqkkAAAAADPOqG_qKv0GgReqhRMgBi9RzTl3';//secret key from recaptcha admin file
    
   $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['token']);//verify the response with the token generated from the user inout

$verify_data = json_decode($verifyResponse, true);//decode the JSON file received from google
$score = $verify_data['score'];//identify the score
//if the score is above 0.7 then process the contact form

if($score>=0.7){
    //set up variables
    $visitor_email = filter_var($_POST['visitor_email'], FILTER_SANITIZE_EMAIL);
    $visitor_phone = filter_var($_POST['visitor_phone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $visitor_name = filter_var($_POST['visitor_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $visitor_message = filter_var($_POST['visitor_message'], FILTER_SANITIZE_SPECIAL_CHARS);
        // Email address verification.
        function isEmail($email)
        {
            return (preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
        }
        //check values from form and remove whitespace
        if (trim($visitor_name) == '') { // name
            echo '<div id="response"></div><div class="form-response error">You must enter your name. Please try again.</div>';
            exit();
        }else if (!isEmail($visitor_email)) {
            echo '<div id="response"></div><div class="form-response error">Invalid email address. Please try again.</div><br>';
            exit();
        } else if (trim($visitor_phone) == '') {
            echo '<div id="response"></div><div class="form-response error">You must enter your phone number. Please try again.</div><br>';
            exit();
        }

/////////////////////////////////////////////////////////Send Emails /////////////////////////////////////////////////////////////////
    //configure email to send to admins
   // stored in seperate file
    //From Server
    $fromserver    = $username;


    ///////////////////Admins auto reply/////////////////////////
        //email subject
        $subject = $visitor_name .' has contacted you from your website';


        //body of email for website admins
        $body = '<div style="background-color:#a67d6e; padding:16px;font-family:sans-serif;">
            <h1 style="text-align:center; color:white;">' . $visitor_name .' has contaced you.</h1>
            <div style="background-color: white; padding:16px; border: 10px solid #F2F2F2; border-radius: 10px;">
                <h2>Message Details:</h2>
                <p style="border-bottom:1px solid;"><strong>Name</strong>: ' . $visitor_name.' </p>
                <p style="border-bottom:1px solid;"><strong>Email</strong>: ' . $visitor_email . ' </p>
                <p style="border-bottom:1px solid;"><strong>Phone No</strong>.: ' . $visitor_phone . ' </p>
                <p style="border-bottom:1px solid;"><strong>Message:</strong></p>
                <p style="border-bottom:1px solid;">'.$visitor_message.'</p>

            </div>
        </div>';


        //Auto Reply email settings to send notifaction to admins
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Host = $host; // Enter your host here
        $mail->SMTPAuth = true;
        $mail->Username = $username; // Enter your email here
        $mail->Password = $pass; //Enter your password here
        $mail->Port = 25;
        $mail->From = $from;
        $mail->FromName = $fromname;
        $mail->Sender = $fromserver; // indicates ReturnPath header
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->AddAddress($email_to);
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $response="<div class='form-response'><p>Thank you <strong>$visitor_name</strong>, for requesting a quotation from us.<br>We will be in touch with you very soon! </p></div>"; 
    }






}else{//if the score fails, exit the script and send back an error
    $response = '<div class="form-response error"><p>Security check failed</p></div>';
    echo $response;
    exit();
}

}else{
    $response = '<div class="form-response error"><p>Security check failed</p></div>';
    echo $response;
    exit();
}
$response = '<div class="form-response"><p>Thank you for your message. We will respond to you as soon as we can.</p></div>';

echo $response;
