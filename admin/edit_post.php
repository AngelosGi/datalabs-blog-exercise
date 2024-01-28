<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . '/..');
}

require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/functions.php';
require_once ROOT_PATH . '/includes/error_handler.php';
include_once ROOT_PATH . '/templates/header.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in'])) {
    handleError(new Exception('You must be logged in as an admin to perform this action.'));
}

// Check if the post ID is provided in the URL
if (!isset($_GET['id'])) {
    handleError(new Exception('Missing post ID.'));
}

$postId = $_GET['id'];

try {
    // Retrieve the post data
    $post = getPost($pdo, $postId);

    // Check if the post exists
    if (!$post) {
        handleError(new Exception('Post not found!'));
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Validate form data
        if (empty($title) || empty($content) || empty($author)) {
            handleError(new Exception('Please fill all required fields!'));
        }

        // Update the post in the database
        $sql = 'UPDATE posts SET title = ?, content = ?, author = ? WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $author, $postId]);

        // Redirect to the post view page
        header('Location: index.php?page=post&id=' . $postId);
        exit;
    }
} catch (PDOException $e) {
    handleError($e);
}
?>

<body class="bg-gray-900">

<!-- Edit Post Form -->
<div class="mx-auto max-w-xl px-4 py-8"> <!-- Start of Tailwind CSS container for the form -->
    <form method="post" class="space-y-4">
        <label for="title" class="block text-sm font-medium text-gray-200">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required class="block w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-900">
        <label for="content" class="block text-sm font-medium text-gray-200">Content:</label>
        <textarea id="content" name="content" required class="block w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-900"><?php echo htmlspecialchars($post['content']); ?></textarea>
        <label for="author" class="block text-sm font-medium text-gray-200">Author:</label>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($post['author']); ?>" required class="block w-full px-4 py-2 border border-gray-300 rounded bg-white text-gray-900">
        <input type="submit" value="Update Post" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
    </form>
</div> <!-- End of Tailwind CSS container for the form -->

</body>
