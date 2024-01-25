<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <nav class="p-6 bg-white flex justify-between items-center">
        <a href="index.php?page=home" class="text-3xl font-bold text-gray-900">Home</a>
        <div class="space-x-4">
            <?php if (!isset($_SESSION['admin_logged_in'])): ?>
                <a href="index.php?page=login" class="text-gray-600 hover:text-gray-900">Admin Login</a>
            <?php else: ?>
                <?php if ((isset($_GET['page']) ? $_GET['page'] : 'home') != 'create_post'): ?>
                    <a href="index.php?page=create_post" class="text-gray-600 hover:text-gray-900">Create Post</a>
                <?php endif; ?>
                <a href="index.php?page=logout" class="text-gray-600 hover:text-gray-900">Logout</a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Rest of your HTML content -->
</body>
</html>