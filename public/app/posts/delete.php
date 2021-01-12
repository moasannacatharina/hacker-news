<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
} else {
    $post_id = $_GET['id'];
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('DELETE FROM posts WHERE id = :post_id AND user_id = :user_id');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['message'] = 'Your post has been deleted.';

    redirect('/submitted.php');
}
