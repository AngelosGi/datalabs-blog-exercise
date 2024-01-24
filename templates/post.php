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

    echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
    echo '<p>' . htmlspecialchars($post['content']) . '</p>';
    echo '<p>Posted by ' . htmlspecialchars($post['author']) . ' on ' . htmlspecialchars($post['date']) . '</p>';
    echo '<a href="index.php?page=edit_post&id=' . htmlspecialchars($post['id']) . '">Edit Post</a>';

    echo '<form method="POST" action="admin/delete_post.php" onsubmit="return confirm(\'Are you sure you want to delete this post?\');">';
    echo '<input type="hidden" name="id" value="' . htmlspecialchars($post['id']) . '">';
    echo '<input type="submit" value="Delete Post">';
    echo '</form>';

    $sql = 'SELECT * FROM comments WHERE post_id = ? ORDER BY date DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $comments = $stmt->fetchAll();

    foreach ($comments as $comment) {
        echo '<h3>' . htmlspecialchars($comment['author']) . ' said:</h3>';
        echo '<p>' . htmlspecialchars($comment['content']) . '</p>';
        echo '<p>Posted on ' . htmlspecialchars($comment['date']) . '</p>';
        
        echo '<form method="POST" action="admin/delete_comment.php" onsubmit="return confirm(\'Are you sure you want to delete this comment?\');">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($comment['id']) . '">';
        echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post['id']) . '">';
        echo '<input type="submit" value="Delete Comment">';
        echo '</form>';
    }
} catch (PDOException $e) {
    handleError($e);
}

?>




<form method="post" action="public/add_comment.php">
    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($id); ?>">
    <label for="author">Name:</label><br>
    <input type="text" id="author" name="author" required><br>
    <label for="content">Comment:</label><br>
    <textarea id="content" name="content" required></textarea><br>
    <input type="submit" value="Submit">
</form>



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