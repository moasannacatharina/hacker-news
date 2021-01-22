<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);

?>
<article>
    <h1>Create new account</h1>
    <?php if ($error_message !== '') : ?>
        <div class="alert alert-danger">
            <?= $error_message; ?>
        </div><!-- /alert -->
    <?php endif; ?>
    <form action="app/users/register.php" method="post">
        <div class="form-group">
            <label for="password">First name</label>
            <input class="form-control" type="name" name="first_name" id="first_name" required>
            <small class="form-text text-muted">Please provide your first name.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Last name</label>
            <input class="form-control" type="name" name="last_name" id="last_name" required>
            <small class="form-text text-muted">Please provide your last name.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="Email" required>
            <small class="form-text text-muted">Please provide your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required>
            <small class="form-text text-muted">Please provide your password (passphrase).</small>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-primary">Create account</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
