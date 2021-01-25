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
    <br>
    <p class="create-account-text"> An Email will be sent to you with instructions how to reset your long lost password </p>

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
    <form action="app/users/password-email-reset.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" required>
            <small class="form-text text-muted">Please provide your email address.</small>
        </div>

        <button type="submit" class="btn btn-primary" id="log-in-btn">Reset your password!</button>

    </form>


</article>

<?php require __DIR__ . '/views/footer.php'; ?>
