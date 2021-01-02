<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}


if (isset($_POST)) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    $statement = $database->prepare('UPDATE posts SET title = :title WHERE id = :id');
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $statement = $database->prepare('SELECT * FROM posts WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
}



redirect('/submitted.php');
