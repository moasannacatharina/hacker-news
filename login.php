<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

?>
<article>
    <h1>Login</h1>

    <?php if ($error_message !== '') : ?>
        <div class="alert alert-danger">
            <?= $error_message; ?>
        </div><!-- /alert -->
    <?php elseif ($message !== '') : ?>
        <div class="alert alert-success">
            <?= $message; ?>
        </div><!-- /alert -->
    <?php endif; ?>
    <form action="app/users/login.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" required>
            <small class="form-text text-muted">Please provide the your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required>
            <small class="form-text text-muted">Please provide the your password (passphrase).</small>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-primary" id="log-in-btn">Login</button>
        <p class="create-account-text">Don't have an account? Create an account <a href="/register.php">here</a></p>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
