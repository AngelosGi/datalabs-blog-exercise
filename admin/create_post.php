<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__ . '/..');
}
require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/functions.php';
require_once ROOT_PATH . '/includes/error_handler.php';
include_once ROOT_PATH . '../templates/header.php';

if (!isset($_SESSION['admin_logged_in'])) {
    handleError(new Exception('You must be logged in as an admin to perform this action.'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($title) || empty($content) || empty($author)) {
        handleError(new Exception('Please fill all required fields!'));
        // die('Please fill all required fields!');
    }

    try {
        $sql = 'INSERT INTO posts (title, content, author, date) VALUES (?, ?, ?, NOW())';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $author]);

    header('Location: index.php');
    exit;
    }catch (PDOException $e) {
        handleError($e);
    }

    
}
?>

<form method="post">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br>
    <label for="content">Content:</label><br>
    <textarea id="content" name="content" required></textarea><br>
    <label for="author">Author:</label><br>
    <input type="text" id="author" name="author" required><br>
    <input type="submit" value="Submit">
</form>
<!-- required -->