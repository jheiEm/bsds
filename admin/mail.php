<?php
//  use PHPMailer\PHPMailer\PHPMailer;
//  use PHPMailer\PHPMailer\Exception;
//  require 'PHPMailer-master/src/Exception.php';
//  require 'PHPMailer-master/src/PHPMailer.php';
//  require 'PHPMailer-master/src/SMTP.php';
//
//function send_mail($recipient,$subject,$message)
//{
//
//  $mail = new PHPMailer();
//  $mail->IsSMTP();
//
//  $mail->SMTPDebug  = 0;
//  $mail->SMTPAuth   = TRUE;
//  $mail->SMTPSecure = "tls";
//  $mail->Port       = 587;
//  $mail->Host       = "smtp.gmail.com";
//  //$mail->Host       = "smtp.mail.yahoo.com";
//  $mail->Username   = "merujeshua14@gmail.com";
//  $mail->Password   = "jqzd zcgp lthn dkkk";
//
//  $mail->IsHTML(true);
//  $mail->AddAddress($recipient, "");
//  $mail->SetFrom("merujeshua14@gmail.com", "Batangas Province Scholarship Disbursement Management System");
//  //$mail->AddReplyTo("reply-to-email", "reply-to-name");
//  //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
//  $mail->Subject = $subject;
//  $content = $message;
//
//  $mail->MsgHTML($content);
//  if(!$mail->Send()) {
//    //echo "Error while sending Email.";
//    //echo "<pre>";
//    //var_dump($mail);
//    return false;
//  } else {
//    //echo "Email sent successfully";
//    return true;
//  }
//
//}
//
//?>

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
