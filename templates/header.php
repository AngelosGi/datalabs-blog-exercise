<?php session_start(); ?>

<nav>
    <a href="../public/index.php">Home</a>
    |
    <?php if (!isset($_SESSION['admin_logged_in'])): ?>
        <a href="../public/login.php">Admin Login</a>
    <?php else: ?>
        <?php if ($_SERVER['SCRIPT_NAME'] != '/datalabs-blog-exercise/admin/add_post.php'): ?>
            <a href="../admin/add_post.php">Create Post</a>
            |
        <?php endif; ?>
        <a href="../admin/logout.php">Logout</a>
    <?php endif; ?>
</nav>
