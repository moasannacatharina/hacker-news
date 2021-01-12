<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}
$id = $_SESSION['user']['id'];
?>

<article>
    <h2>
        Are you sure you want to delete your account?
    </h2>
    <p>
        if you continue, you will delete all of your posts, comments and user-info.
    </p>
    <a href="/user.php?id=<?= $id ?>">
        Cancel
    </a>
    <a href="/app/users/delete.php?id=<?= $id ?>">
        Delete account
    </a>
</article>
