<?php
require_once '../includes/db.php';


try {
    $id = $_GET['id'];

    $sql = 'SELECT * FROM posts WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    $post = $stmt->fetch();

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
