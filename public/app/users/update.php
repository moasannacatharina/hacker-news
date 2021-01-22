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

    $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if ($_SESSION['authenticated']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'bio' => $user['biography'],
        ];
        $_SESSION['message'] = 'Your email has been updated!';
    } else {
        $_SESSION['error_message'] = 'Whoops! Something went wrong. Try again later.';
    };

    redirect('/user.php');
}


if (isset($_POST['bio'])) {
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('UPDATE users SET biography = :biography WHERE id = :id');
    $statement->bindParam(':biography', $bio, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if ($_SESSION['authenticated']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'bio' => $user['biography'],
        ];
        $_SESSION['message'] = 'Your biography has been saved!';
    } else {
        $_SESSION['error_message'] = 'Whoops! Something went wrong. Try again later.';
    };


    redirect('/user.php');
}

if (isset($_POST['new_password'])) {
    $id = $_SESSION['user']['id'];

    $new_password = $confirm_password = "";


    if (strlen(trim($_POST["new_password"])) < 6) {
        $_SESSION['error_message'] = "Password must have atleast 6 characters.";
        redirect('/user.php');
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($_SESSION['error_message']) && ($new_password != $confirm_password)) {
        $_SESSION['error_message'] = "Passwords did not match.";
        redirect('/user.php');
    }

    if (empty($_SESSION['error_message'])) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $statement = $database->prepare('UPDATE users SET password = :password WHERE id = :id');
        $statement->bindParam(':password', $new_password, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        $_SESSION['message'] = 'Your password has been updated!';

        redirect('/user.php');
    }
}

if (isset($_FILES['image'])) {
    $file = $_FILES['image'];

    if ($file['type'] !== 'image/jpeg') {
        $_SESSION['error_message'] = 'The chosen file type is not allowed';
        redirect('/user.php');
    } elseif ($file['size'] > 3145728) {
        $_SESSION['error_message'] = 'The uploaded file exceeded the file size limit.';
        redirect('/user.php');
    } else {
        $new_file_name = $_SESSION['user']['id'] . '.jpg';
        $uploads_dir = '/images/';

        $destination = __DIR__ . $uploads_dir . $new_file_name;

        move_uploaded_file($file['tmp_name'], $destination);
        $_SESSION['message'] = "Success! Your profile image has been updated.";
        $_SESSION['image'] = $new_file_name;
    }
    redirect('/user.php');
}
