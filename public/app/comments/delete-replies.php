<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
} else {
    $post_id = $_GET['id'];
    $reply_id = $_GET['reply-id'];
    $user_id = $_SESSION['user']['id'];

    $statement = $database->prepare('DELETE FROM replies WHERE id = :id AND user_id = :user_id AND post_id = :post_id');
    $statement->bindParam(':id', $reply_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->execute();



    $_SESSION['message'] = 'Your comment has been deleted.';

    redirect('/post.php?id=' . $post_id);
}
