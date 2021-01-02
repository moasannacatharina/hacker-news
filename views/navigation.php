<nav>
    <a class="navbar-brand" href="/"><?php echo $config['title']; ?></a>

    <button>
        <img src="/assets/images/menu.svg" class="menu-btn" />
    </button>
    <section class="menu-list">
        <button>
            <img src="/assets/images/cancel.svg" class="close-btn" />
        </button>
        <ul class="navbar-nav">
            <li class="nav-item
        <?php if ($_SERVER['PHP_SELF'] === '/index.php') : ?>
                active
        <?php endif; ?>">
                <a class="nav-link" href="/index.php">Home</a>
            </li>

            <li class="nav-item
        <?php if ($_SERVER['PHP_SELF'] === '/submit.php') : ?>
                active
        <?php endif; ?>">
                <a class="nav-link" href="/submit.php">Submit</a>
            </li>

            <?php if (isset($_SESSION['user'])) : ?>
                <li class="nav-item
                <?php if ($_SERVER['PHP_SELF'] === '/user.php') : ?>
                    active
                <?php endif; ?>">
                    <a class="nav-link" href="/user.php?id=<?= $_SESSION['user']['id'] ?>">Your profile</a>
                </li><!-- /nav-item -->
                <li class="nav-item
                <?php if ($_SERVER['PHP_SELF'] === '/logout.php') : ?>
                active
                <?php endif; ?>">
                    <a class="nav-link" href="/app/users/logout.php">Logout</a>
                </li>
            <?php else : ?>
                <li class="nav-item
                <?php if ($_SERVER['PHP_SELF'] === '/login.php') : ?>
                active
                <?php endif; ?>">
                    <a class="nav-link" href="/login.php">Login</a>
                </li><!-- /nav-item -->
                <li class="nav-item
                <?php if ($_SERVER['PHP_SELF'] === '/register.php') : ?>
                active
                <?php endif; ?>">
                    <a class="nav-link" href="/register.php">Create account</a>
                </li>
            <?php endif; ?>
        </ul><!-- /navbar-nav -->
    </section>
</nav><!-- /navbar -->
