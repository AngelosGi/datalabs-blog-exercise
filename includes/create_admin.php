<?php
require_once '../includes/db.php';

$username = 'admin';
$password = password_hash('admin', PASSWORD_DEFAULT);

try {
    $sql = 'INSERT INTO admin (username, password) VALUES (?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password]);

    echo 'Admin user created successfully';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}