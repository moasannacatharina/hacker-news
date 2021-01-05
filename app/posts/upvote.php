<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['upvote'])) {
    $post_id = $_GET['id'];
    // die(var_dump($post_id));
    $user_id = $_SESSION['user']['id'];


    $statement = $database->prepare('INSERT INTO upvotes (post_id, user_id) VALUES(:post_id, :user_id)');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $statement->execute();

    redirect('/');
}
