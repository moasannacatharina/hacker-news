<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);

$fileName = 'app/users/images/' . $_SESSION['user']['id'] . '.jpg';

?>

<article>
    <div>
        <?php if ($message !== '') : ?>
            <div class="alert alert-success">
                <?= $message; ?>
            </div><!-- /alert -->
        <?php endif; ?>
        <?php if ($error_message !== '') : ?>
            <div class="alert alert-danger">
                <?= $error_message; ?>
            </div><!-- /alert -->
        <?php endif; ?>
    </div>
    <div class="user-info">
        <?php if (is_file($fileName) && file_exists($fileName)) : ?>
            <img src="<?= $fileName ?>" class="profile-img" alt="profile image of <?= $_SESSION['user']['email'] ?>" />
        <?php else : ?>
            <img src="/app/users/images/avatar.png" class="profile-img" />
        <?php endif; ?>
        <div class=" user-info-text">
            <h1>
                <?= $_SESSION['user']['first_name']; ?>
            </h1>
            <p>
                <?= $_SESSION['user']['bio']; ?>
            </p>
        </div>
    </div>

    <section class="update-profile">
        <form action="app/users/update.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Upload profile image</label>
                <input class="form-control" type="file" name="image" id="image" accepts=".jpg" />
                <!-- <small class="form-text text-muted">Choose a PNG image to upload.</small> -->
            </div><!-- /form-group -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="app/users/update.php" method="post">
            <div class="form-group">
                <label for="biography">Update your bio</label>
                <textarea class="form-control" rows="5" cols="5" type="text" name="bio" id="bio"><?= $_SESSION['user']['bio']; ?></textarea>
                <!-- <small class="form-text text-muted">Write something about yourself</small> -->
            </div><!-- /form-group -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="app/users/update.php" method="post">
            <div class="form-group">
                <label for="email">Change email address</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="<?= $_SESSION['user']['email']; ?>" />
                <!-- <small class="form-text text-muted">Edit your email address here.</small> -->
            </div><!-- /form-group -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="app/users/update.php" method="post">
            <div class="form-group">
                <label for="password">Update password</label>
                <input class="form-control" type="password" name="new_password" id="new_password" />
                <!-- <small class="form-text text-muted">Edit your password here.</small> -->
            </div><!-- /form-group -->
            <div class="form-group">
                <label for="password">Confirm new password</label>
                <input class="form-control" type="password" name="confirm_password" id="confirm_password" />
                <!-- <small class="form-text text-muted">Confirm your password here.</small> -->
            </div><!-- /form-group -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </section>
    <div class="user-links">
        <a href="/submitted.php?id=<?= $_SESSION['user']['id']; ?>">
            Submissions
        </a>
        <a href="/delete-account.php?id=<?= $_SESSION['user']['id']; ?>">
            Delete account
        </a>
    </div>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>
