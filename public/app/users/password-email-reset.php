<?php

declare(strict_types=1);

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader

require __DIR__ . '/../autoload.php';
require __DIR__ . '/../../vendor/autoload.php';  //  D:\Desktop\moas\hacker-newsplus\public\vendor

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost:8000/create-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $tokenExpires = date("U") + 900;

    $statement = $database->prepare('DELETE FROM password_resets WHERE reset_email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    if (!$statement) {
        $_SESSION['error_message'] = 'Whoops! There was an error!';
        redirect('/create-password.php');
    }

    $hashedToken = password_hash($token, PASSWORD_DEFAULT);

    $statement = $database->prepare("INSERT INTO password_resets (reset_email, reset_selector, reset_token, reset_expires) VALUES (:email, :selector, :hashedToken, :tokenExpires);");
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':selector', $selector, PDO::PARAM_STR);
    $statement->bindParam(':hashedToken', $hashedToken, PDO::PARAM_STR);
    $statement->bindParam(':tokenExpires', $tokenExpires, PDO::PARAM_STR);
    $statement->execute();

    $sendTo = $email;

    $emailSubject = 'Reset your password for Hacker news';

    $emailMessage = 'A request has been made to reset your password. The link to reset your password is below. If you did not sent this request, please ignore this email.';
    $emailMessage .= 'Here is your password reset link: ';  // .= means it will continue on the message. (A concatentation.)
    $emailMessage .= '<a href="' . $url . ' ">' . $url  . '; </a>';
}
try {
    //Server settings
    $mail->SMTPDebug = 1;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'idatestcode@gmail.com';                     // SMTP username
    $mail->Password   = 'b689.to?2VfyMTQn2cZg4_yZ';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('idatestcode@gmail.com', 'Hacker News');
    $mail->addAddress($sendTo, 'User');     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Reset your password';
    $mail->Body    = $emailMessage;
    $mail->AltBody =  $emailMessage;  // 'This is the body in plain text for non-HTML mail clients'

    $mail->send();
    $_SESSION['message'] = "A link has now been sent to the email you entered!";
    redirect('/create-password.php');
} catch (Exception $e) {
    $_SESSION['error_message'] = "Email could not be sent, please try again";
    redirect('/create-password.php');
}
