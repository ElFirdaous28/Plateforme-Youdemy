<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendTeacherActivationEmail($RecipientEmail, $RecipientName)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.mailtrap.io';           // Mailtrap SMTP server
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'b1ff058a8905cc'; // Your Mailtrap SMTP username
        $mail->Password = '9a5764e0891c7b'; // Your Mailtrap SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port = 2525;                         // TCP port to connect to (2525, 465, or 587)

        // Recipients
        $mail->setFrom($RecipientEmail, $RecipientName);
        $mail->addAddress($RecipientEmail, $RecipientName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Youdemy : Your Account Has Been Activated';
        $mail->Body = "<p>Dear $RecipientName,</p>
                       <p>We are pleased to inform you that your account has been successfully activated. You can now access all the features available to teachers on our platform.</p>
                       <p>If you have any questions or need assistance, feel free to reach out to us.</p>
                       <p>Best regards</p>";
        // Send the email
        $mail->send();
        echo "email sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        die;
    }
}
