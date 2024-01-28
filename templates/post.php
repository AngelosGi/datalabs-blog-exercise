<?php
require_once ROOT_PATH . '/includes/functions.php';

if (!isset($_GET['id'])) {
    handleError(new Exception('Missing post id'));
}

$id = $_GET['id'];

try {
    $post = getPost($pdo, $id);

    if (!$post) {
        handleError(new Exception('Post not found!'));
    }

    echo '<body class="bg-gray-900">'; // Opening body tag with bg-gray-900 class
    echo '<div class="max-w-7xl mx-auto mt-5 px-4 sm:px-6 lg:px-8 py-6 bg-white rounded-lg shadow">'; // Opening post section
    echo '<h2 class="text-2xl font-bold text-gray-900">' . htmlspecialchars($post['title']) . '</h2>';
    echo '<p class="mt-2 text-gray-600">' . htmlspecialchars($post['content']) . '</p>';
    echo '<p class="mt-2 text-sm text-gray-500">Posted by ' . htmlspecialchars($post['author']) . ' on ' . htmlspecialchars($post['date']) . '</p>';

    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
        echo '<div class="mt-4 flex">';
        echo '<form method="GET" action="index.php" class="mr-4">';
        echo '<input type="hidden" name="page" value="edit_post">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($post['id']) . '">';
        echo '<button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-blue-500 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Edit Post</button>';
        echo '</form>';

        echo '<form method="POST" action="admin/delete_post.php" onsubmit="return confirm(\'Are you sure you want to delete this post?\');">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($post['id']) . '">';
        echo '<button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-red-500 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete Post</button>';
        echo '</form>';
        echo '</div>';
    }

    echo '</div>'; // Closing post section
    echo '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 bg-white rounded-lg shadow mt-6">'; // Opening comments section
    echo '<div class="mb-4">'; // Opening comments container
    echo '<h3 class="text-lg font-semibold mb-4">Comments</h3>';
    $sql = 'SELECT * FROM comments WHERE post_id = ? ORDER BY date DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $comments = $stmt->fetchAll();

    foreach ($comments as $comment) {
        echo '<div class="mt-4">';
        echo '<p class="text-sm text-gray-400">' . htmlspecialchars($comment['author']) . ' said:</p>';
        echo '<p class="mt-1 text-gray-700">' . htmlspecialchars($comment['content']) . '</p>';
        echo '<p class="mt-1 text-xs text-gray-500">Posted on ' . htmlspecialchars($comment['date']) . '</p>';

        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
            echo '<form method="POST" action="admin/delete_comment.php" class="inline">';
            echo '<input type="hidden" name="id" value="' . htmlspecialchars($comment['id']) . '">';
            echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post['id']) . '">';
            echo '<button type="submit" class="text-xs text-red-500 hover:underline">Delete Comment</button>';
            echo '</form>';
        }
        echo '</div>';
    }

    echo '</div>'; // Closing comments container
    echo '</div>'; // Closing comments section container

    echo '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 bg-white rounded-lg shadow mt-6">'; // Opening comment form section
    echo '<form class="mt-6" method="post" action="public/add_comment.php" onsubmit="return validateForm()">'; // Opening comment form
    echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($id) . '">';
    echo '<div class="mb-4">';
    echo '<label for="author" class="block text-sm font-medium text-gray-900">Name:</label>';
    echo '<input type="text" id="author" name="author" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>';
    echo '</div>';
    echo '<div class="mb-4">';
    echo '<label for="content" class="block text-sm font-medium text-gray-900">Comment:</label>';
    echo '<textarea id="content" name="content" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>';
    echo '</div>';
    echo '<button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Submit</button>';
    echo '</form>'; // Closing comment form
    echo '</div>'; // Closing comment form section

    echo '</body>'; // Closing body tag
} catch (PDOException $e) {
    handleError($e);
}
?>

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
