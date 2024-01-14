<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
</head>
<body>

<?php include '../templates/header.php'; ?>

    <h1>Welcome to My Blog</h1>

<?php 
require_once '../includes/db.php';

try {
    $sql = 'SELECT * FROm posts ORDER BY date DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $posts = $stmt->fetchAll();

    foreach ($posts as $post) {
        echo '<h2>' . htmlspecialchars($post ['title']) . '</h2>';
        echo '<p>' . htmlspecialchars($post['content']) . '</p>';
        echo '<p>Posted by ' . htmlspecialchars($post['author']) . '</p>';
        echo '<a href="post.php?id=' . htmlspecialchars($post['id']) . '">Read more</a>';
    }
} catch (PDOException $e) {
    echo 'Error:' . $e->getMessage();
}





?>

</body>
</html>