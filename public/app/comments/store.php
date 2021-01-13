<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['message'] = '';

if (isset($_SESSION['user'])) {
    if (isset($_POST['comment'])) {
        $content = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
        $post_id = $_GET['id'];
        $id = $_SESSION['user']['id'];
        $created_at = date("Y-m-d H:i:s");

        $statement = $database->prepare('INSERT INTO comments (content, created_at, post_id, user_id) VALUES (:content, :created_at, :post_id, :user_id)');
        $statement->bindParam(':content', $content, PDO::PARAM_STR);
        $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();

        redirect('/post.php?id=' . $post_id);
    } elseif (isset($_POST['reply'])) {
        $content = filter_var($_POST['reply'], FILTER_SANITIZE_STRING);
        $post_id = $_GET['id'];
        $comment_id = $_GET['comment-id'];
        $id = $_SESSION['user']['id'];
        $created_at = date("Y-m-d H:i:s");

        $statement = $database->prepare('INSERT INTO replies (created_at, content, comment_id, post_id, user_id) VALUES (:created_at, :content, :comment_id, :post_id, :user_id)');
        $statement->bindParam(':content', $content, PDO::PARAM_STR);
        $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
        $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();

        redirect('/post.php?id=' . $post_id);
    }
} else {
    $_SESSION['error_message'] = 'You have to be logged in to comment.';
    redirect('/login.php');
}
