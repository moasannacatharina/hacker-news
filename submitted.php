<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}


$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);


$user_id = $_SESSION['user']['id'];

$statement = $database->prepare('SELECT * FROM posts WHERE user_id = :user_id ORDER BY id DESC');
$statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<article class="own-submissions">
    <?php if ($message !== '') : ?>
        <div class="alert alert-success">
            <?= $message; ?>
        </div><!-- /alert -->
    <?php endif; ?>
    <h1>Your submissions</h1>
    <ul>
        <?php foreach ($posts as $post) : ?>
            <?php $_SESSION['post'] = $post; ?>
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
                <a href="/edit-post.php?id=<?= $post['id']; ?>" id="edit-post">
                    Edit
                </a>
                <a href="/app/posts/delete.php?id=<?= $post['id']; ?>" id="delete-post">
                    Delete
                </a>
            </div>
        <?php endforeach; ?>
    </ul>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
