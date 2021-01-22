<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['message'] = '';

if (isset($_SESSION['user'])) {
    if (isset($_POST['edit-reply'])) {
        $comment = filter_var($_POST['edit-reply'], FILTER_SANITIZE_STRING);
        $reply_id = $_GET['id'];
        $post_id = $_GET['post-id'];
        $user_id = $_SESSION['user']['id'];

        $statement = $database->prepare('UPDATE replies SET content = :content WHERE id = :reply_id AND user_id = :user_id AND post_id = :post_id');
        $statement->bindParam(':content', $comment, PDO::PARAM_STR);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->bindParam(':reply_id', $reply_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        $_SESSION['message'] = 'Your changes have been saved.';

        redirect('/post.php?id=' . $post_id);
    }
} else {
    redirect('/login.php');
}
