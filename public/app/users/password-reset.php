<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['selector'], $_POST['validator'], $_POST['password'], $_POST['password-repeat'])) {
    $selector = filter_var($_POST['selector'], FILTER_SANITIZE_STRING);
    $validator = filter_var($_POST['validator'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $repeatPwd = filter_var($_POST['password-repeat'], FILTER_SANITIZE_STRING);

    $url = "/create-password.php?selector=" . $selector . "&validator=" . $validator;

    if ($password !== $repeatPwd) {
        $_SESSION['error_message'] = "Password did not match.";
        redirect($url);
    }

    if (strlen(trim($_POST["password"])) < 6) {
        $_SESSION['error_message'] = "Password must have atleast 6 characters.";
        redirect($url);
    }
    $password = ($_POST["password"]);

    $currentTime = date("U"); // not being used at this moment.
    $statement = $database->query("SELECT * FROM password_resets WHERE reset_selector = '$selector'");

    /** This is commented because there is a struggle with prepare statement.
     * TO DO: Try to solve why it does not work.
     */
    //$statement->bindParam(':selector', $selector, PDO::PARAM_STR);
    //$statement->bindParam(':currentTime', $currentTime, PDO::PARAM_STR);
    //$statement->execute();

    //die(var_dump($statement->queryString));
    // $statement = $database->prepare("SELECT * FROM `password_resets` WHERE `reset_selector` = '$selector'");
    // $statement->bindParam(':selector', $selector, PDO::PARAM_STR);
    //$statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $_SESSION['error_message'] = "Time has run out. You need to re-send your request.";
        redirect('/reset-password.php');
    }

    $tokenBinary = hex2bin($validator); // convert back to binary

    if (password_verify($tokenBinary, $result['reset_token'])) {
        $resetEmail = $result['reset_email'];

        $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindParam(':email', $resetEmail, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['error_message'] = "Time has run out. You need to re-send your request.";
        redirect("/login.php");
    }

    if (!is_array($user)) {
        $_SESSION['error_message'] = "Something went wrong with the email";
        redirect("/login.php"); // ändra denna
    } else {
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

        $statement = $database->prepare('UPDATE users SET password = :password WHERE email = :email');
        $statement->bindParam(':password', $passwordHashed, PDO::PARAM_STR);
        $statement->bindParam(':email', $resetEmail, PDO::PARAM_STR);
        $statement->execute();

        $statement = $database->prepare('DELETE FROM password_resets WHERE reset_email = :email');
        $statement->bindParam(':email', $resetEmail, PDO::PARAM_STR);
        $statement->execute();

        $_SESSION['message'] = 'Your password has been updated. Please log in below.';
        redirect('/login.php');
    }
}
