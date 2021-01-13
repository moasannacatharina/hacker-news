<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['message'] = '';

if (isset($_SESSION['user'])) {
    if (isset($_POST['edit'])) {
        $comment = filter_var($_POST['edit'], FILTER_SANITIZE_STRING);
        $post_id = $_GET['id'];
        $comment_id = $_GET['comment-id'];
        $user_id = $_SESSION['user']['id'];

        $statement = $database->prepare('UPDATE comments SET content = :content WHERE id = :comment_id AND user_id = :user_id AND post_id = :post_id');
        $statement->bindParam(':content', $comment, PDO::PARAM_STR);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        $_SESSION['message'] = 'Your changes have been saved.';

        redirect('/post.php?id=' . $post_id);
    }
} else {
    redirect('/login.php');
}
