<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}

$post_id = $_GET['id'];

$statement = $database->prepare('DELETE FROM posts WHERE id = :post_id');
$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);


$statement->execute();

$statement = $database->query('SELECT * FROM posts WHERE id = :post_id');

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['message'] = 'Your post has been deleted.';

redirect('/submitted.php');
