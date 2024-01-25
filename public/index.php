<!DOCTYPE html>
<html>
<head>

</head>
<body class="bg-gray-900">


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <div class="lg:col-span-2 space-y-6">
                <?php 
                require_once ROOT_PATH . '/includes/functions.php';
                require_once ROOT_PATH . '/includes/error_handler.php';

                try {
                    $posts = getAllPosts($pdo);

                    foreach ($posts as $post) {
                        echo '<div class="p-6 bg-white rounded-lg shadow">';
                        echo '<h2 class="text-2xl font-bold text-gray-900">' . htmlspecialchars($post['title']) . '</h2>';
                        echo '<p class="mt-2 text-gray-600">' . htmlspecialchars($post['content']) . '</p>';
                        echo '<p class="mt-2 text-sm text-gray-500">Posted by ' . htmlspecialchars($post['author']) . '</p>';
                        echo '<a href="index.php?page=post&id=' . htmlspecialchars($post['id']) . '" class="mt-4 inline-block text-blue-500 hover:underline">Read more</a>';
                        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
                            echo '<a href="index.php?page=edit_post&id=' . htmlspecialchars($post['id']) . '" class="mt-4 ml-4 inline-block text-blue-500 hover:underline">Edit Post</a>';
                        }
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    handleError($e);
                }
                ?>
            </div>
            <div class="lg:col-span-1 space-y-6">
                <!-- Sidebar content goes here -->
            </div>
        </div>
    </div>
</body>
</html>