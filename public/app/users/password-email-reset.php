<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost:8000/create-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    // change url ? I have not createt a forgottenpwd map

    $tokenExpires = date("U") + 900;

    $statement = $database->prepare('DELETE FROM password_resets WHERE reset_email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    if (!$statement) {
        $_SESSION['error_message'] = 'Whoops! There was an error!';
    }

    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $statement = $database->prepare("INSERT INTO password_resets (reset_email, reset_selector, reset_token, reset_expires) VALUES (:email, :selector, :token, :tokenExpires);");
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':selector', $selector, PDO::PARAM_STR);
    $statement->bindParam(':token', $hashedToken, PDO::PARAM_STR);
    $statement->bindParam(':tokenExpires', $tokenExpires, PDO::PARAM_STR);
    $statement->execute();

    $sendTo = $email;

    $emailSubject = 'Reset your password for Hacker news';

    $emailMessage = 'A request has been made to reset your password. The link to reset your password is below. If you did not sent this request, please ignore this email.';
    $emailMessage .= 'Here is your password reset link: ';  // .= means it will continue on the message. (A concatentation.)
    $emailMessage .= '<a href="' . $url . ' ">' . $url  . '; </a>';


    $headers = "From: Hacker News <idatestcode@gmail.com> \n";
    $headers .= "Content-type: text/html\n";


    mail($sendTo, $emailSubject, $emailMessage, $headers);

    $_SESSION['message'] = "A link has now been sent to the email you entered!";
    redirect('/create-password.php');


    /*
Possibly not have this, token will be sent to the email entered.
    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $statement->fetch(PDO::FETCH_ASSOC);

    if (!is_array($statement)) {
        $_SESSION['error_message'] = 'Whoops! Email does not exists';
        redirect('/reset-password.php');
    }


*/
} else {
    redirect('/index.php');
}
