<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['message'] = '';

if (isset($_POST)) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $post_id = $_GET['id'];

    $statement = $database->prepare('UPDATE posts SET title = :title, url = :url, description = :description WHERE id = :post_id');
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':url', $url, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);

    $statement->execute();

    $statement = $database->query('SELECT * FROM posts WHERE id = :post_id');

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['message'] = 'Your post has been saved.';
}



redirect('/submitted.php');
