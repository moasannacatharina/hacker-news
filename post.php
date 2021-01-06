<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);


$post_id = $_GET['id'];

$statement = $database->prepare('SELECT posts.id, posts.title, posts.url, posts.description, posts.created_at, posts.user_id, users.email
FROM posts
INNER JOIN users
ON posts.user_id = users.id
WHERE posts.id = :post_id LIMIT 1');

$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();


$statement = $database->query('SELECT * FROM comments');
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
$fileName = 'app/users/images/' . $post['user_id'] . '.jpg';
// die(var_dump($post));

?>


<article class="single-post">
    <div class="poster">
        <?php if (is_file($fileName) && file_exists($fileName)) : ?>
            <img src="<?= $fileName ?>" class="profile-img" />
        <?php else : ?>
            <img src="/app/users/images/avatar.png" class="profile-img" />
        <?php endif; ?>
        <div class="post-info">
            <a href="<?= $post['url']; ?>">
                <h3>
                    <?= $post['title']; ?>
                </h3>
            </a>
            <p>
                <?= $post['description']; ?>
            </p>
        </div>
    </div>


    <div class="subtext">
        <?php $upvotes = countUpvotes($database, $post['id']); ?>
        <?php if ($upvotes == 1) : ?>
            <p>
                <?= $upvotes; ?> vote
            </p>
        <?php else : ?>
            <p>
                <?= $upvotes; ?> votes
            </p>
        <?php endif; ?>
        <p>
            <?= $post['email']; ?>
        </p>
        <p>
            <?= $post['created_at']; ?>
        </p>

    </div>

    <form action="app/comments/store.php?id=<?= $post['id']; ?>" method="post">
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea class="form-control" rows="5" cols="5" type="text" name="comment" id="comment"></textarea>
            <!-- <small class="form-text text-muted">Write something about yourself</small> -->
        </div><!-- /form-group -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
