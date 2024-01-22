//not working.

<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . '/..');
}

require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/functions.php';
require_once ROOT_PATH . '/includes/error_handler.php';
include_once ROOT_PATH . '../templates/header.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in'])) {
    handleError(new Exception('You must be logged in as an admin to perform this action.'));
}

// Check if the comment ID is provided in the URL
if (!isset($_GET['id'])) {
    handleError(new Exception('Missing comment ID.'));
}

$commentId = $_GET['id'];

try {
    // Retrieve the comment data
    $comment = getComment($pdo, $commentId);

    // Check if the comment exists
    if (!$comment) {
        handleError(new Exception('Comment not found!'));
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Delete the comment from the database
        $sql = 'DELETE FROM comments WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$commentId]);

        // Redirect to the post view page
        header('Location: ' . BASE_URL . '/index.php?page=post&id=' . $comment['post_id']);
        exit;
    }
} catch (PDOException $e) {
    handleError($e);
}
?>



<!-- Delete Comment Form -->
<form method="post">
    <p>Are you sure you want to delete this comment?</p>
    <input type="submit" value="Delete Comment">
</form>

