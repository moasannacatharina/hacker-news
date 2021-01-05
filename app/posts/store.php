<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['message'] = '';

if (isset($_POST['title'], $_POST['url'], $_POST['description'])) {
    $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
    $url = trim(filter_var($_POST['url'], FILTER_SANITIZE_URL));
    $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
    $created_at = date("Y-m-d");
    $id = $_SESSION['user']['id'];



    $statement = $database->prepare('INSERT INTO posts (title, url, description, created_at, user_id) VALUES (:title, :url, :description, :created_at, :user_id)');
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':url', $url, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
    $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['message'] = 'Your post has been submitted!';
}
redirect('/submit.php');
