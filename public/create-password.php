<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

?>
<article>
    <h2>Reset your password</h2>

    <?php if ($error_message !== '') : ?>
        <div class="alert alert-danger">
            <?= $error_message; ?>
        </div><!-- /alert -->
    <?php elseif ($message !== '') : ?>
        <div class="alert alert-success">
            <?= $message; ?>
        </div><!-- /alert -->
    <?php endif; ?>

    <!-- LOGIN FORM  -->


    <?php if (isset($_GET['selector'], $_GET['validator'])) {
        $selector = filter_var($_GET['selector'], FILTER_SANITIZE_STRING);
        $validator = filter_var($_GET['validator'], FILTER_SANITIZE_STRING);

        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) : ?>
            <form action="app/users/password-reset.php" method="post">
                <div class="form-group">
                    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                    <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                    <label for="password">Create new password</label>
                    <input class="form-control" type="password" name="password" id="password" required>
                    <small class="form-text text-muted">Please provide your new password (minimum 6 characters) (passphrase).</small>
                    <label for="password-repeat">Repeat your password</label>
                    <input class="form-control" type="password" name="password-repeat" id="password-repeat" required>
                    <small class="form-text text-muted">Please repeat your password (passphrase).</small>
                </div>

                <button type="submit" class="btn btn-primary" id="log-in-btn">Reset password!</button>

            </form>


        <?php endif; ?>
    <?php } ?>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>
