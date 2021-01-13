<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);

    if (strlen(trim($_POST["password"])) < 6) {
        $_SESSION['error_message'] = "Password must have atleast 6 characters.";
        redirect('/register.php');
    } else {
        $password = trim($_POST["password"]);
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $statement = $database->prepare('INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['message'] = 'Your account has been created. Please log in below.';
    redirect('/login.php');
}

redirect('/register.php');
