<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

function send_mail($recipients, $subject, $message, $bcc = []) {
    // Create a new instance of PHPMailer
    $mail = new PHPMailer();
    $mail->IsSMTP();

    // SMTP configuration
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "merujeshua14@gmail.com";
    $mail->Password   = "jqzd zcgp lthn dkkk";

    // Set email format to HTML
    $mail->IsHTML(true);

    // Add main recipients
    if (is_array($recipients)) {
        foreach ($recipients as $recipient) {
            $mail->AddAddress($recipient, "");
        }
    } else {
        $mail->AddAddress($recipients, "");
    }

    // Add BCC recipients if any
    if (!empty($bcc)) {
        foreach ($bcc as $bccEmail) {
            $mail->addBCC($bccEmail);  // Add each BCC recipient
        }
    }

    // Set From address
    $mail->SetFrom("merujeshua14@gmail.com", "Batangas Province Scholarship Disbursement Management System");

    // Set the email subject and content
    $mail->Subject = $subject;
    $mail->MsgHTML($message);

    // Send the email and return the result
    if (!$mail->Send()) {
        return false; // Email sending failed
    } else {
        return true; // Email sent successfully
    }
}

?>