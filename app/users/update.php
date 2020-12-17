<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('UPDATE users SET email = :email WHERE id = :id');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    redirect('/user.php');
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $id = $_SESSION['user']['id'];

    $password = password_hash($password, PASSWORD_DEFAULT);
    $statement = $database->prepare('UPDATE users SET password = :password WHERE id = :id');
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    redirect('/user.php');
}

if (isset($_POST['biography'])) {
    $bio = $_POST['biography'];
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('UPDATE users SET biography = :biography WHERE id = :id');
    $statement->bindParam(':biography', $bio, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    redirect('/user.php');
}

// if(isset($_POST['avatar'])) {


//     $avatar = $_POST['avatar'];


//     $password = password_hash($password, PASSWORD_DEFAULT);


//     $statement->bindParam(':password', $password, PDO::PARAM_STR);
//     $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
//     $statement->bindParam(':last_name', $last_name, PDO::PARAM_STR);
//     $statement->execute();

//     $user = $statement->fetch(PDO::FETCH_ASSOC);


// }

// redirect('/users.php');
