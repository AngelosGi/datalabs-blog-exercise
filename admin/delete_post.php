<?php
session_start();
define('ROOT_PATH', __DIR__ . '/..'); //last thing that worked. it deletes but not redirects
require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/functions.php';
require_once ROOT_PATH . '/includes/error_handler.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in'])) {
    handleError(new Exception('You must be logged in as an admin to perform this action.'));
}

// Check if the post ID is provided in the POST request
if (!isset($_POST['id'])) {
    handleError(new Exception('Missing post ID.'));
}

$postId = $_POST['id'];

try {
    // Retrieve the post data
    $post = getPost($pdo, $postId);

    // Check if the post exists
    if (!$post) {
        handleError(new Exception('Post not found!'));
    }

    // Delete the post from the database
    $sql = 'DELETE FROM posts WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId]);

    // Redirect to the admin dashboard or posts list page
    header('Location: ../index.php?page=home');
    exit;
} catch (PDOException $e) {
    handleError($e);
}
?>