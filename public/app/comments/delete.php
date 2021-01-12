<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
} else {
    $post_id = $_GET['id'];
    $comment_id = $_GET['comment-id'];
    $user_id = $_SESSION['user']['id'];

    $statement = $database->prepare('DELETE FROM comments WHERE id = :id AND user_id = :user_id');
    $statement->bindParam(':id', $comment_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    // $statement = $database->query('SELECT * FROM posts WHERE id = :post_id');
    // $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['message'] = 'Your comment has been deleted.';

    redirect('/post.php?id=' . $post_id);
}
