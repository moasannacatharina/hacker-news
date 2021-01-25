<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['selector'], $_POST['validator'], $_POST['password'], $_POST['passwordrepeat'])) {
    $selector = filter_var($_POST['selector'], FILTER_SANITIZE_STRING);
    $validator = filter_var($_POST['validator'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $repeatPwd = filter_var($_POST['password-repeat'], FILTER_SANITIZE_STRING);

    $url = "/create-new-password.php?selector=" . $selector . "&validator=" . $validator;

    if ($password !== $repeatPwd) {
        $_SESSION['error_message'] = "Password did not match.";
        redirect("$url");
    }

    if (strlen(trim($_POST["password"])) < 6) {
        $_SESSION['error_message'] = "Password must have atleast 6 characters.";
        redirect('$url');
    }
    $password = trim($_POST["password"]);


    $currentTime = date("U");
    $statement = $database->prepare("SELECT * FROM password_resets WHERE reset_selector = :selector AND reset_expires >= $currentTime");
    $statement->bindParam(':selector', $selector, PDO::PARAM_STR);
    $statement->execute();

    if (!$statement) {
        $_SESSION['error_message'] = "Time has run out. You need to re-send your request.";
    } else {

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $tokenBinary = hex2bin($validator);
        $validateToken = password_verify($tokenBinary, $result['reset_token']);

        if ($validateToken === false) {
            $_SESSION['error_message'] = "Time has run out. You need to re-send your request.";
        } elseif ($validateToken === true) {
            $resetEmail = $result['reset_email'];

            $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
            $statement->bindParam(':email', $resetEmail, PDO::PARAM_STR);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!is_array($user)) {
                $_SESSION['error_message'] = "Something went wrong with the email";
                redirect("/index.php"); // ändra denna
            } else {
                $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

                $statement = $database->prepare('UPDATE users SET (password) VALUES (:password) WHERE email = :email');
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
    }
}
