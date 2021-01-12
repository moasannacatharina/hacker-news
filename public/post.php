<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);


$post_id = $_GET['id'];
// die(var_dump($post_id));

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



$fileName = 'app/users/images/' . $post['user_id'] . '.jpg';


// KOLLAR OM ANVÄNDAREN LIKEAT EN POST OCH DÄRIGENOM BESTÄMMA FÄRG PÅ UPVOTE-KNAPPEN
if (isset($_SESSION['user'])) {
    $post_id = $post['id'];
    $user_id = $_SESSION['user']['id'];

    $statement = $database->prepare('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $upvote = $statement->fetch();
}

?>


<article class="single-post">
    <?php if ($message !== '') : ?>
        <div class="alert alert-success">
            <?= $message; ?>
        </div><!-- /alert -->
    <?php endif; ?>
    <div class="poster">
        <?php if (is_file($fileName) && file_exists($fileName)) : ?>
            <img src="<?= $fileName ?>" class="profile-img" />
        <?php else : ?>
            <img src="/app/users/images/avatar.png" class="profile-img" />
        <?php endif; ?>
        <div class="post-info">
            <div>
                <button data-url="<?= $post['id']; ?>" class="upvote-btn
                <?php if (isset($_SESSION['user'])) : ?>
                    <?php if ($upvote !== false) : ?>
                        upvote-btn-darker
                    <?php endif; ?>
                <?php endif; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.171 512.171">
                        <path d="M476.723 216.64L263.305 3.115A10.652 10.652 0 00255.753 0a10.675 10.675 0 00-7.552 3.136L35.422 216.64c-3.051 3.051-3.947 7.637-2.304 11.627a10.67 10.67 0 009.856 6.571h117.333v266.667c0 5.888 4.779 10.667 10.667 10.667h170.667c5.888 0 10.667-4.779 10.667-10.667V234.837h116.885c4.309 0 8.192-2.603 9.856-6.592 1.664-3.989.725-8.554-2.326-11.605z" />
                    </svg>
                </button>
                <a href="<?= trim($post['url']); ?>">
                    <h3>
                        <?= trim($post['title']); ?>
                    </h3>
                </a>
            </div>
            <p>
                <?= $post['description']; ?>
            </p>
        </div>
    </div>


    <div class="subtext">
        <?php $upvotes = countUpvotes($database, $post['id']); ?>
        <?php $numberOfComments = countComments($database, $post['id']); ?>
        <div>
            <?php if ($upvotes == 1) : ?>
                <span class="number-of-votes" data-url="<?= $post['id']; ?>">
                    <?= $upvotes; ?> vote
                </span>
            <?php else : ?>
                <span class="number-of-votes" data-url="<?= $post['id']; ?>">
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
        <div class="comment" data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>">
            <p class="comment-user">
                <?= $comment['email'] . ' ' . $comment['created_at']; ?>
            </p>
            <?php if (isset($_SESSION['user'])) : ?>
                <?php if ($comment['user_id'] === $_SESSION['user']['id']) : ?>
                    <div class="edit-comment-container">
                        <button data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>" class="edit-comment">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 383.947 383.947" class="edit-symbol">
                                <path d="M0 303.947v80h80l236.053-236.054-80-80zM377.707 56.053L327.893 6.24c-8.32-8.32-21.867-8.32-30.187 0l-39.04 39.04 80 80 39.04-39.04c8.321-8.32 8.321-21.867.001-30.187z" />
                            </svg>
                        </button>
                        <a href="/app/comments/delete.php?comment-id=<?= $comment['id']; ?>&id=<?= $comment['post_id']; ?>" class="delete-comment">
                            X
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <p class="comment-content" data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>">
                <?= $comment['content']; ?>
            </p>
        </div>

        <form action="/app/comments/update.php?id=<?= $comment['post_id']; ?>&comment-id=<?= $comment['id']; ?>" class="comment-form-hidden" data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>" method="post">
            <div class="form-group">
                <label for="edit">Edit Comment</label>
                <textarea class="form-control" rows="10" cols="5" type="text" name="edit" id="edit"><?= $comment['content']; ?></textarea>
                <!-- <small class="form-text text-muted">Write something about yourself</small> -->
            </div><!-- /form-group -->
            <button type="submit" class="edit-comment-save">Save</button>
        </form>



    <?php endforeach; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
