<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    if (empty($title) || empty($content) || empty($author)) {
        die('Please fill all required fields!');
    }

    try {
        $sql = 'INSERT INTO posts (title, content, author, date) VALUES (?, ?, ?, NOW())';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $author]);

    header('Location: index.php');
    exit;
    }catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
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