<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['error_message'] = '';

if (isset($_SESSION['user']['id'])) {
    if (isset($_POST)) {
        $post_id = $_GET['id'];
        $user_id = $_SESSION['user']['id'];

        // FINNS den redan i databasen?

        $statement = $database->prepare('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $upvote = $statement->fetch();

        if ($upvote === false) {

            $statement = $database->prepare('INSERT INTO upvotes (post_id, user_id) VALUES(:post_id, :user_id)');
            $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            $statement->execute();
        } else {
            $statement = $database->prepare('DELETE FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
            $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            $statement->execute();
        }

        $upvotes = countUpvotes($database, $post_id);
        echo json_encode($upvotes);
    } else {
        $_SESSION['error_message'] = 'You have to be logged in to vote.';
        redirect('/login.php');

        // die(var_dump($upvote));
    }
}
