<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<article>

    <img src="" />
    <h1>
        <?= $_SESSION['user']['first_name']; ?>
    </h1>

    <form action="app/users/update.php" method="post">
        <div class="form-group">
            <label for="biography">Update your bio</label>
            <input class="form-control" type="text" name="bio" id="bio" />
            <small class="form-text text-muted">Write something about yourself</small>
        </div><!-- /form-group -->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <form action="app/users/update.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="avatar">Upload avatar image</label>
            <input class="form-control" type="file" name="avatar" id="avatar" accept=".png" />
            <small class="form-text text-muted">Choose a PNG image to upload.</small>
        </div><!-- /form-group -->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <form action="app/users/update.php" method="post">
        <div class="form-group">
            <label for="email">Change email address</label>
            <input class="form-control" type="email" name="email" id="email" />
            <small class="form-text text-muted">Edit your email address here.</small>
        </div><!-- /form-group -->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <form action="app/users/update.php" method="post">
        <div class="form-group">
            <label for="password">Change password</label>
            <input class="form-control" type="password" name="password" id="password" />
            <small class="form-text text-muted">Edit your password here.</small>
        </div><!-- /form-group -->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

</article>
