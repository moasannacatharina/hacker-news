<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

$statement = $database->prepare('SELECT * FROM posts WHERE user_id = :user_id');
$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<article class="own-submissions">
    <h1>Your submissions</h1>
    <ul>
        <?php foreach ($posts as $post) : ?>
            <li class="submitted-post">
                <a href="<?= $post['url']; ?>">
                    <?= $post['title']; ?>
                </a>
                <p>
                    <?= $post['description']; ?>
                </p>
            </li>
            <div class="subtext">
                <?= $post['created_at']; ?>
                <button class="edit-post">
                    Edit
                </button>
            </div>
            <div class="edit-invisible">
                <h5>Edit Post</h5>
                <form action="app/posts/update.php" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control" type="title" name="title" id="title" placeholder="<?= $post['title']; ?>">
                    </div><!-- /form-group -->

                    <div class="form-group">
                        <label for="url">Url</label>
                        <input class="form-control" type="url" name="url" id="url" placeholder="<?= $post['url']; ?>">
                    </div><!-- /form-group -->

                    <div class=" form-group">
                        <label for="description">Description</label>
                        <input class="form-control" rows="10" cols="15" type="text" name="description" id="description" placeholder="<?= $post['description']; ?>">
                    </div><!-- /form-group -->

                    <button type="submit" class="btn btn-primary">Save</button>
            </div>
        <?php endforeach; ?>
    </ul>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
