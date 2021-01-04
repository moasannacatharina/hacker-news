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



    /// POST_ID?? HUR SKA JAG VETA EN SPECIFIK POSTS ID?
    $statement = $database->query('SELECT * FROM posts ORDER BY id DESC LIMIT 1');
    $post = $statement->fetch();

    $post_id = $post['id'];
    $post_user_id = $post['user_id'];
    $number_of_upvotes = 0;

    $statement = $database->prepare('INSERT INTO upvotes (number_of_upvotes, user_id, post_id) VALUES (:number_of_upvotes, :user_id, :post_id)');
    $statement->bindParam(':number_of_upvotes', $number_of_upvotes, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $post_user_id, PDO::PARAM_INT);
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['message'] = 'Your post has been submitted!';
}
redirect('/submit.php');
