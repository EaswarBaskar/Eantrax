<?php
// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['number'];
    $city = $_POST['city'];
    $message = $_POST['comment'];

    $mail = new PHPMailer(true);

    try {
        // SMTP Settings for Hostinger
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'support@eantrax.com'; // Your domain email
        $mail->Password = 'YOsxient';  // Enter your password here
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Email Settings
        $mail->setFrom('support@eantrax.com', 'Website Contact Form');
        $mail->addAddress('eanexsolution@gmail.com'); // Your receiving email
        $mail->addReplyTo($email, $name);

        // Email Body
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission from '.$name;
        $mail->Body = "
            <h2>Contact Form Details</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>City:</strong> $city</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        // Send Email
        $mail->send();

        // WhatsApp Alert
        $whatsappNumber = "918681971839"; // Your WhatsApp number
        $whatsappMessage = "New Inquiry:%0A"
            . "Name: $name%0A"
            . "Email: $email%0A"
            . "Phone: $phone%0A"
            . "City: $city%0A"
            . "Message: $message";

        // Redirect to WhatsApp
        header("Location: https://api.whatsapp.com/send?phone=$whatsappNumber&text=$whatsappMessage");
        exit();

    } catch (Exception $e) {
        // Display error for debugging
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    header('Location: index.html');
    exit();
}
?>
