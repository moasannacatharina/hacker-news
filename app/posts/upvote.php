<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['upvote'])) {
    $post_id = $_SESSION['post']['id'];
    die(var_dump($post_id));

    $statement = $database->prepare('UPDATE upvotes SET number_of_upvotes = `number_of_upvotes`+1 WHERE post_id = :post_id');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);

    $statement->execute();

    redirect('/');
}
