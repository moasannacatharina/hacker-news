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

function countComments($database, int $postId)
{

    $statement = $database->prepare('SELECT COUNT(*) FROM comments WHERE post_id = :postId');
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $numberOfComments = $statement->fetch();

    return $numberOfComments['COUNT(*)'];
}

function convertTime($time)
{
    $time = time() - $time; // to get the time since that moment
    if ($time < 1) {
        $time = 1;
    } else {
        $time = $time;
    }
    $tokens = [
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    ];

    foreach ($tokens as $token => $text) {
        if ($time < $token) {
            continue;
        }
        $numberOfTokens = floor($time / $token);
        return $numberOfTokens . ' ' . $text . (($numberOfTokens > 1) ? 's' : '');
    }
}
