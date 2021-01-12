<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}

$post_id = $_GET['id'];
$statement = $database->prepare('SELECT * FROM posts WHERE id = :post_id LIMIT 1');
$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();

$post = $statement->fetch();

?>

<article>
    <h2>Edit Post</h2>
    <form action="app/posts/update.php?id=<?= $post['id']; ?>" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input class="form-control" type="title" name="title" id="title" value="<?= $post['title']; ?>">
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="url">Url</label>
            <input class="form-control" type="url" name="url" id="url" value="<?= $post['url']; ?>">
        </div><!-- /form-group -->

        <div class=" form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="10" cols="15" type="text" name="description" id="description"><?= $post['description']; ?></textarea>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-primary">Save</button>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
