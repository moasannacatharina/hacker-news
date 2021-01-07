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


$statement = $database->prepare('SELECT comments.id, comments.content, comments.created_at, comments.post_id, comments.user_id, users.email
FROM comments
INNER JOIN users
ON comments.user_id = users.id
WHERE comments.post_id = :post_id
ORDER BY comments.id ASC');

$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

// die(var_dump($comments));
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
            <div>
                <a aria-label="upvote-button" href="/app/posts/upvote.php?id=<?= $post['id']; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.171 512.171" class="upvote-btn">
                        <path d="M476.723 216.64L263.305 3.115A10.652 10.652 0 00255.753 0a10.675 10.675 0 00-7.552 3.136L35.422 216.64c-3.051 3.051-3.947 7.637-2.304 11.627a10.67 10.67 0 009.856 6.571h117.333v266.667c0 5.888 4.779 10.667 10.667 10.667h170.667c5.888 0 10.667-4.779 10.667-10.667V234.837h116.885c4.309 0 8.192-2.603 9.856-6.592 1.664-3.989.725-8.554-2.326-11.605z" />
                    </svg>
                </a>
                <a href="<?= $post['url']; ?>">
                    <h3>
                        <?= $post['title']; ?>
                    </h3>
                </a>
            </div>
            <p>
                <?= $post['description']; ?>
            </p>
        </div>
    </div>


    <div class="subtext">
        <?php $upvotes = countUpvotes($database, $post['id']);
        $numberOfComments = countComments($database, $post['id']) ?>
        <div>
            <?php if ($upvotes == 1) : ?>
                <span>
                    <?= $upvotes; ?> vote
                </span>
            <?php else : ?>
                <span>
                    <?= $upvotes; ?> votes
                </span>
            <?php endif; ?>
            <?php if ($numberOfComments == 1) : ?>
                <span>
                    <?= $numberOfComments; ?> comment
                </span>
            <?php else : ?>
                <span>
                    <?= $numberOfComments; ?> comments
                </span>
            <?php endif; ?>
        </div>
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
<article class="comments">
    <?php foreach ($comments as $comment) : ?>
        <div class="comment">
            <p class="comment-user">
                <?= $comment['email'] . ' ' . $comment['created_at']; ?>
            </p>
            <p class="comment-content">
                <?= $comment['content']; ?>
            </p>
            <?php if (isset($_SESSION['user'])) : ?>
                <?php if ($comment['user_id'] === $_SESSION['user']['id']) : ?>
                    <a class="delete-comment" href="/app/comments/delete.php?comment-id=<?= $comment['id']; ?>&id=<?= $comment['post_id']; ?>">
                        X
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
