<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$fileName = __DIR__ . '/images/' . $_SESSION['user']['id'] . '.jpg';

if (isset($_SESSION['user'])) {
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('DELETE FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM posts WHERE user_id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM upvotes WHERE user_id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM comments WHERE user_id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();


    if (file_exists($fileName)) {
        // die(var_dump($fileName));
        unlink($fileName);
    }

    unset($_SESSION['user']);
    $_SESSION['message'] = "Your account has been deleted.";
    redirect('/login.php');
}
