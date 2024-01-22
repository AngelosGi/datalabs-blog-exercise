<?php

session_start();

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . '/..');
}

require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/functions.php';
require_once ROOT_PATH . '/includes/error_handler.php';
include_once ROOT_PATH . '/templates/header.php'; // Corrected path

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_logged_in'])) {
    handleError(new Exception('You must be logged in as an admin to perform this action.'));
    exit();
}

// Check if the post ID is provided in the URL
if (!isset($_GET['id'])) {
    handleError(new Exception('Missing post ID.'));
    exit();
}

$postId = $_GET['id'];

try {
    // Retrieve the post data
    $post = getPost($pdo, $postId);

    // Check if the post exists
    if (!$post) {
        handleError(new Exception('Post not found!'));
        exit();
    }

    // Delete the post in the database
    $sql = 'DELETE FROM posts WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$postId]);

    // Redirect to the main page
    header('Location: ' . BASE_URL . '/index.php');
    exit;
} catch (PDOException $e) {
    handleError($e);
    exit();
}
?>