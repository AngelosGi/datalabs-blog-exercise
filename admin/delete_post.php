<?php 
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    echo 'You must be logged in as an admin to perform this action.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        $sql = 'DELETE FROM posts WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $sql = 'DELETE FROM comments WHERE post_id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        header('Location: ../public/index.php');
        exit;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
