<?php

require_once ROOT_PATH . '/includes/functions.php';

if (!isset($_GET['id'])) {
    handleError(new Exception('Missing post id'));
}

$id = $_GET['id'];

try {
    $post = getPost($pdo,$id);

    if (!$post) {
        handleError(new Exception('Post not found!'));
    }

    echo '<div class="mx-auto max-w-xl px-4 py-8">'; // Start of Tailwind CSS container
    echo '<h2 class="text-2xl font-bold mb-4">' . htmlspecialchars($post['title']) . '</h2>';
    echo '<p class="mb-4">' . htmlspecialchars($post['content']) . '</p>';
    echo '<p class="text-sm text-gray-500 mb-4">Posted by ' . htmlspecialchars($post['author']) . ' on ' . htmlspecialchars($post['date']) . '</p>';

    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
        echo '<form method="GET" action="index.php" class="mb-4">';
        echo '<input type="hidden" name="page" value="edit_post">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($post['id']) . '">';
        echo '<input type="submit" value="Edit Post" class="px-4 py-2 bg-blue-500 text-white rounded">';
        echo '</form>';

        echo '<form method="POST" action="admin/delete_post.php" onsubmit="return confirm(\'Are you sure you want to delete this post?\');" class="mb-4">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($post['id']) . '">';
        echo '<input type="submit" value="Delete Post" class="px-4 py-2 bg-red-500 text-white rounded">';
        echo '</form>';
    }

    $sql = 'SELECT * FROM comments WHERE post_id = ? ORDER BY date DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $comments = $stmt->fetchAll();

    foreach ($comments as $comment) {
        echo '<h3 class="text-lg font-bold mb-2">' . htmlspecialchars($comment['author']) . ' said:</h3>';
        echo '<p class="mb-2">' . htmlspecialchars($comment['content']) . '</p>';
        echo '<p class="text-sm text-gray-500 mb-4">Posted on ' . htmlspecialchars($comment['date']) . '</p>';

        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
            echo '<form method="POST" action="admin/delete_comment.php" onsubmit="return confirm(\'Are you sure you want to delete this comment?\');" class="mb-4">';
            echo '<input type="hidden" name="id" value="' . htmlspecialchars($comment['id']) . '">';
            echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post['id']) . '">';
            echo '<input type="submit" value="Delete Comment" class="px-4 py-2 bg-red-500 text-white rounded">';
            echo '</form>';
        }
    }
    echo '</div>'; // End of Tailwind CSS container
} catch (PDOException $e) {
    handleError($e);
}

?>

<div class="mx-auto max-w-xl px-4 py-8"> <!-- Start of Tailwind CSS container for the form -->
<form method="post" action="public/add_comment.php" class="space-y-4">
    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($id); ?>">
    <label for="author" class="block text-sm font-medium text-gray-700">Name:</label>
    <input type="text" id="author" name="author" required class="block w-full px-4 py-2 border border-gray-300 rounded">
    <label for="content" class="block text-sm font-medium text-gray-700">Comment:</label>
    <textarea id="content" name="content" required class="block w-full px-4 py-2 border border-gray-300 rounded"></textarea>
    <input type="submit" value="Submit" class="px-4 py-2 bg-blue-500 text-white rounded">
</form>
</div> <!-- End of Tailwind CSS container for the form -->

<script>
function validateForm() {
    var author = document.getElementById('author').value;
    var content = document.getElementById('content').value;

    if (author == "" || content == "") {
        alert("Name and comment must be filled out");
        return false;
    }
}
</script>