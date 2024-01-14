<?php 
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        $sql = 'DELETE FROM posts WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $sql = 'DELETE FROM comments WHERE post_id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
