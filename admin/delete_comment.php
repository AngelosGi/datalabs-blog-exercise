<?php
session_start();
define('ROOT_PATH', __DIR__ . '/..');
require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/functions.php';
require_once ROOT_PATH . '/includes/error_handler.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in'])) {
    handleError(new Exception('You must be logged in as an admin to perform this action.'));
}

// Check if the comment ID is provided in the POST request
if (!isset($_POST['id'])) {
    handleError(new Exception('Missing comment ID.'));
}

$commentId = $_POST['id'];
$postId = $_POST['post_id'];

try {
    // Retrieve the comment data
    $comment = getComment($pdo, $commentId);

    // Check if the comment exists
    if (!$comment) {
        handleError(new Exception('Comment not found!'));
    }

    // Delete the comment from the database
    $sql = 'DELETE FROM comments WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$commentId]);

    // Redirect to the admin dashboard or comments list page
    header('Location: ../index.php?page=post&id=' . $postId);
    exit;
} catch (PDOException $e) {
    handleError($e);
}
?>