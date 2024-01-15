<?php 
require_once ROOT_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['post_id'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Input validation
    if (empty($id) || empty($author) || empty($content)) {
        die('Please fill all required fields!');
    }

    try {
        $sql = 'INSERT INTO comments (post_id, author, content, date) VALUES (?, ?, ?, NOW())';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id, $author, $content]);

        header('Location: post.php?id=' . $id);
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>