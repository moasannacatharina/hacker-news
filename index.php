<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?= $_SESSION['user']['first_name'] ?>!</p>
    <?php endif; ?>
</article>

<?php if (isset($_SESSION['user'])) : ?>
    <?php $posts = $_SESSION['posts']; ?>
    <article class="content-list">
        <button>New</button>
        <button>Most liked</button>
        <ol>
            <?php foreach ($posts as $post) : ?>
                <li>
                    <a href="<?= $post['url']; ?>">
                        <?= $post['title']; ?>
                    </a>
                </li>
                <div class="subtext">
                    <?= $post['created_at']; ?>
                    <a href="">
                        View more
                    </a>
                    <button>
                        Comment
                    </button>
                </div>
            <?php endforeach; ?>
        </ol>
    </article>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
