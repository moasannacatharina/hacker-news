<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['error_message'] = '';

if (isset($_SESSION['user']['id'])) {
    if (isset($_POST)) {
        $commentId = $_GET['id'];
        $user_id = $_SESSION['user']['id'];

        $statement = $database->prepare('SELECT * FROM comments_upvotes WHERE comment_id = :comment_id AND user_id = :user_id');
        $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        $commentsUpvote = $statement->fetch();

        if ($commentsUpvote === false) {
            $statement = $database->prepare('INSERT INTO comments_upvotes (comment_id, user_id) VALUES(:comment_id, :user_id)');
            $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            $statement->execute();
        } else {
            $statement = $database->prepare('DELETE FROM comments_upvotes WHERE comment_id = :comment_id AND user_id = :user_id');
            $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            $statement->execute();
        }

        // omvandlar mängden upvotes till json-data som fångas upp i JS.
        $commentUpvotes = countCommentsUpvotes($database, $commentId);
        echo json_encode($commentUpvotes);
    }
} else {
    $_SESSION['error_message'] = 'You have to be logged in to vote.';
    redirect('/login.php');
}
