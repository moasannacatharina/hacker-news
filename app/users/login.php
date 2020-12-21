<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$authenticated = $_SESSION['authenticated'] ?? false;

// In this file we login users.
if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];


    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if (
        isset($user['password']) &&
        password_verify($password, $user['password'])
    ) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'bio' => $user['biography'],
        ];
        $_SESSION['authenticated'] = true;
        redirect('/');
    } else {
        $_SESSION['message'] = "Invalid login credentials. Please try again.";
        redirect('/login.php');
    }
}
