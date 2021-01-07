<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

$statement = $database->prepare('SELECT posts.id, posts.title, posts.url, posts.description, posts.created_at, posts.user_id, users.email
FROM posts
INNER JOIN users
ON posts.user_id = users.id
ORDER BY posts.id DESC');
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<article>
    <h1 class="glow"><?php echo $config['title']; ?></h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?= $_SESSION['user']['first_name'] ?>!</p>
    <?php endif; ?>
</article>

<article class="content-list">
    <button class="new-btn active">New</button>
    <button class="most-liked-btn"><a href="/most-upvoted.php">Most upvoted</a></button>
    <ol>
        <?php foreach ($posts as $post) : ?>
            <li>
                <a aria-label="upvote-button" href="/app/posts/upvote.php?id=<?= $post['id']; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.171 512.171" class="upvote-btn">
                        <path d="M476.723 216.64L263.305 3.115A10.652 10.652 0 00255.753 0a10.675 10.675 0 00-7.552 3.136L35.422 216.64c-3.051 3.051-3.947 7.637-2.304 11.627a10.67 10.67 0 009.856 6.571h117.333v266.667c0 5.888 4.779 10.667 10.667 10.667h170.667c5.888 0 10.667-4.779 10.667-10.667V234.837h116.885c4.309 0 8.192-2.603 9.856-6.592 1.664-3.989.725-8.554-2.326-11.605z" />
                    </svg>
                </a>
                <a href="<?= $post['url']; ?>">
                    <?= $post['title']; ?>
                </a>
            </li>
            <div class="subtext">
                <p>
                    <?= $post['created_at']; ?>
                </p>
                <p>
                    <?= $post['email']; ?>
                </p>

                <?php $upvotes = countUpvotes($database, $post['id']); ?>
                <?php $numberOfComments = countComments($database, $post['id']); ?>
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
                        <a href="/post.php?id=<?= $post['id']; ?>">
                            <?= $numberOfComments; ?> comment
                        </a>
                    <?php else : ?>
                        <a href="/post.php?id=<?= $post['id']; ?>">
                            <?= $numberOfComments; ?> comments
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </ol>
</article>


<?php require __DIR__ . '/views/footer.php'; ?>
