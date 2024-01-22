<?php 
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
}


require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/db.php';
require_once ROOT_PATH . '/includes/error_handler.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['post_id'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Input validation
    if (empty($id) || empty($author) || empty($content)) {
        handleError(new Exception('Please fill all required fields!'));
    }

    try {
        $sql = 'INSERT INTO comments (post_id, author, content, date) VALUES (?, ?, ?, NOW())';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id, $author, $content]);

        header('Location: ' . BASE_URL . '/index.php?page=post&id=' . $id);
        exit;
    } catch (PDOException $e) {
        handleError($e);
    }
}
?>