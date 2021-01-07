<nav>
    <a class="navbar-brand" href="/"><?php echo $config['title']; ?></a>

    <button>
        <svg height="512" viewBox="0 -53 384 384" width="512" xmlns="http://www.w3.org/2000/svg" class="menu-btn">
            <path d="M368 154.668H16c-8.832 0-16-7.168-16-16s7.168-16 16-16h352c8.832 0 16 7.168 16 16s-7.168 16-16 16zm0 0M368 32H16C7.168 32 0 24.832 0 16S7.168 0 16 0h352c8.832 0 16 7.168 16 16s-7.168 16-16 16zm0 0M368 277.332H16c-8.832 0-16-7.168-16-16s7.168-16 16-16h352c8.832 0 16 7.168 16 16s-7.168 16-16 16zm0 0" />
        </svg>
    </button>
    <section class="menu-list">
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.806 409.806" class="close-btn">
                <path d="M228.929 205.01L404.596 29.343c6.78-6.548 6.968-17.352.42-24.132-6.548-6.78-17.352-6.968-24.132-.42-.142.137-.282.277-.42.42L204.796 180.878 29.129 5.21c-6.78-6.548-17.584-6.36-24.132.42-6.388 6.614-6.388 17.099 0 23.713L180.664 205.01 4.997 380.677c-6.663 6.664-6.663 17.468 0 24.132 6.664 6.662 17.468 6.662 24.132 0l175.667-175.667 175.667 175.667c6.78 6.548 17.584 6.36 24.132-.42 6.387-6.614 6.387-17.099 0-23.712L228.929 205.01z" />
            </svg>
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

            <!-- DROP DOWN MENU inside NAV with active state on both 'user.php' and 'submitted.php' -->
            <?php if (isset($_SESSION['user'])) : ?>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropbtn
                        <?php if ($_SERVER['PHP_SELF'] === '/user.php') : ?>
                        active
                        <?php elseif ($_SERVER['PHP_SELF'] === '/submitted.php') : ?>
                        active
                        <?php endif; ?>">
                            <?= $_SESSION['user']['first_name']; ?>
                        </button>
                        <div class="dropdown-content-hidden">
                            <a class="nav-link" href="/user.php?id=<?= $_SESSION['user']['id'] ?>">
                                Your profile
                            </a>
                            <a class="navlink" href="/submitted.php?id=<?= $_SESSION['user']['id']; ?>">
                                Submissions
                            </a>
                        </div>
                    </div>
                </li><!-- /nav-item -->
                <!-- End of drop down menu -->
                <li class="nav-item
                <?php if ($_SERVER['PHP_SELF'] === '/logout.php') : ?>
                active
                <?php endif; ?>">
                    <a class="nav-link" href="/app/users/logout.php">Logout</a>
                </li>
                <!-- IF SESSION USER IS NOT SET:-->
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
