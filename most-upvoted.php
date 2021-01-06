<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php


$statement = $database->prepare('SELECT COUNT(upvotes.post_id) as votes, posts.id, posts.title, posts.url, posts.description, posts.created_at, posts.user_id, users.email
FROM upvotes
INNER JOIN posts
ON upvotes.post_id = posts.id
INNER JOIN users
ON posts.user_id = users.id
GROUP BY upvotes.post_id
ORDER BY votes DESC');
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
    <button class="new-btn"><a href="/">New</a></button>
    <button class="most-liked-btn active">Most upvoted</button>
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
                <a href="/post.php?id=<?= $post['id']; ?>">
                    View more |
                </a>
                <button>
                    Comment
                </button>
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
            </div>
        <?php endforeach; ?>
    </ol>
</article>


<?php require __DIR__ . '/views/footer.php'; ?>
