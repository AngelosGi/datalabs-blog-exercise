
<nav>
    <a href="index.php?page=home">Home</a>
    |
    <?php if (!isset($_SESSION['admin_logged_in'])): ?>
        <a href="index.php?page=login">Admin Login</a>
    <?php else: ?>
        <?php if ((isset($_GET['page']) ? $_GET['page'] : 'home') != 'add_post'): ?>
            <a href="index.php?page=add_post">Create Post</a>
            |
        <?php endif; ?>
        <a href="index.php?page=logout">Logout</a>
    <?php endif; ?>
</nav>