<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}


function countUpvotes($database, int $postId)
{

    $statement = $database->prepare('SELECT COUNT(*) FROM upvotes WHERE post_id = :postId');
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $upvotes = $statement->fetch();

    return $upvotes['COUNT(*)'];
}
