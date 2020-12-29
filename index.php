<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $posts = $_SESSION['posts']; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?= $_SESSION['user']['first_name'] ?>!</p>
    <?php endif; ?>
    <p>This is the home page.</p>
</article>

<?php if (isset($_SESSION['user'])) : ?>
    <?php foreach ($posts as $post) : ?>
        <article>
            <ol>
                <li>
                    <a href="<?= $post['url']; ?>">
                        <?= $post['title']; ?>
                    </a>
                    <p>
                        <?= $post['description']; ?>
                    </p>
                    <small>
                        <?= $post['created_at']; ?>
                    </small>
                </li>
            </ol>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
