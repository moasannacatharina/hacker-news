<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    $_SESSION['error_message'] = 'You need to be logged in to submit posts.';
    redirect("/login.php");
    exit;
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

?>
<article>
    <?php if ($message !== '') : ?>
        <div class="alert alert-success">
            <?= $message; ?>
        </div><!-- /alert -->
    <?php endif; ?>
    <h1>Submit</h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <form action="app/posts/store.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="title" name="title" id="title" required>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="url">Url</label>
                <input class="form-control" type="url" name="url" id="url" required>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="description">Description</label>
                <input class="form-control" rows="10" cols="15" type="text" name="description" id="description" required>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    <?php endif; ?>

</article>


<?php require __DIR__ . '/views/footer.php'; ?>
