<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

$statement = $database->prepare('SELECT posts.id, posts.title, posts.url, posts.description, posts.created_at, posts.user_id, users.email, upvotes.number_of_upvotes
FROM posts
INNER JOIN users
ON posts.user_id = users.id
INNER JOIN upvotes
ON upvotes.post_id = posts.id
ORDER BY posts.id DESC');
$statement->execute();

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

// $_SESSION['posts'] = $posts;

// $statement = $database->query('SELECT * FROM upvotes INNER JOIN posts on upvotes.post_id = posts.id');
// $upvotes = $statement->fetchAll(PDO::FETCH_ASSOC);

// die(var_dump($upvotes));

// die(var_dump($posts));

?>

<article>
    <h1 class="glow"><?php echo $config['title']; ?></h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?= $_SESSION['user']['first_name'] ?>!</p>
    <?php endif; ?>
</article>

<article class="content-list">
    <button class="new-btn active">New</button>
    <button class="most-liked-btn">Most liked</button>
    <ol>
        <?php foreach ($posts as $post) : ?>
            <?php $_SESSION['post']['id'] = $post['id']; ?>
            <?= $_SESSION['post']['id']; ?>
            <li>
                <form action="/app/posts/upvote.php" method="POST">
                    <input type="submit" name="upvote" id="upvote" />
                </form>
                <!-- <button class="upvote-btn">
                    like
                </button> -->
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
                <p><span class="count"><?= $post['number_of_upvotes']; ?></span> points</p>
                <a href="">
                    View more |
                </a>
                <button>
                    Comment
                </button>
            </div>
        <?php endforeach; ?>
    </ol>
</article>


<?php require __DIR__ . '/views/footer.php'; ?>
