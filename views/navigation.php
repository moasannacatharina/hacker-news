<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo $config['title']; ?></a>

    <ul class="navbar-nav">
        <li class="nav-item
        <?php if ($_SERVER['PHP_SELF'] === '/index.php') : ?>
            active <?php endif; ?>">
            <a class="nav-link" href="/index.php">Home</a>
        </li>

        <li class="nav-item
        <?php if ($_SERVER['PHP_SELF'] === '/about.php') : ?>
            active <?php endif; ?>">
            <a class="nav-link" href="/about.php">About</a>
        </li>

        <?php if (!isset($_SESSION['user'])) : ?>
            <li class="nav-item
            <?php if ($_SERVER['PHP_SELF'] === '/login.php') : ?>
            active <?php endif; ?>">
                <a class="nav-link" href="/login.php">Login</a>
            </li><!-- /nav-item -->
            <li class="nav-item
            <?php if ($_SERVER['PHP_SELF'] === '/register.php') : ?>
            active <?php endif; ?>">
                <a class="nav-link" href="/register.php">Create account</a>
            </li>
        <?php else : ?>
            <li class="nav-item
            <?php if ($_SERVER['PHP_SELF'] === '/logout.php') : ?>
            active <?php endif; ?>">
                <a class="nav-link" href="/app/users/logout.php">Logout</a>
            </li><!-- /nav-item -->
        <?php endif; ?>
    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->
