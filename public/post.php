<?php
require_once ROOT_PATH . '/includes/db.php';

include ROOT_PATH . '/templates/header.php';

if (!isset($_GET['id'])) {
    die('Missing post id!');
}

    $id = $_GET['id'];

try {
    $sql = 'SELECT * FROM posts WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $post = $stmt->fetch();

    if (!$post) {
        die('Post not found!');
    }

    echo '<h2>' . htmlspecialchars($post['title']) . '</h2>';
    echo '<p>' . htmlspecialchars($post['content']) . '</p>';
    echo '<p>Posted by ' . htmlspecialchars($post['author']) . ' on ' . htmlspecialchars($post['date']) . '</p>';

    $sql = 'SELECT * FROM comments WHERE post_id = ? ORDER BY date DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $comments = $stmt->fetchAll();

    foreach ($comments as $comment) {
        echo '<h3>' . htmlspecialchars($comment['author']) . ' said:</h3>';
        echo '<p>' . htmlspecialchars($comment['content']) . '</p>';
        echo '<p>Posted on ' . htmlspecialchars($comment['date']) . '</p>';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

?>




<form method="post" action="add_comment.php">
    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($id); ?>">
    <label for="author">Name:</label><br>
    <input type="text" id="author" name="author" required><br>
    <label for="content">Comment:</label><br>
    <textarea id="content" name="content" required></textarea><br>
    <input type="submit" value="Submit">
</form>




<form method="post" action="../admin/delete_post.php">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <input type="submit" value="Delete Post">
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