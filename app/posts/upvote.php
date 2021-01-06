<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['error_message'] = '';

if (isset($_SESSION['user'])) {
    $post_id = $_GET['id'];
    $user_id = $_SESSION['user']['id'];


    $statement = $database->prepare('INSERT INTO upvotes (post_id, user_id) VALUES(:post_id, :user_id)');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $statement->execute();

    redirect('/');
} else {
    $_SESSION['error_message'] = 'You have to be logged in to vote.';
    redirect('/login.php');
}
