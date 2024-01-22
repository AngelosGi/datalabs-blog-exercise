<?php

//get post function
function getPost($pdo, $id) {
    $sql = 'SELECT * FROM posts WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch();
}

function getAllPosts($pdo) {
    $sql = 'SELECT * FROM posts ORDER BY date DESC';
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();

    return $stmt -> fetchAll();
}

function getComment($pdo, $commentId) {
    $sql = 'SELECT * FROM comments WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$commentId]);

    return $stmt->fetch();
}
?>

