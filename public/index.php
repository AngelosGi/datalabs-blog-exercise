<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
</head>
<body>

<!-- <?php 

    require_once ROOT_PATH . '/includes/functions.php';
    require_once ROOT_PATH . '/includes/error_handler.php';
    ?> -->

    <h1>Welcome to My Blog</h1>

<?php 


try {
    
    $posts = getAllPosts($pdo);

    foreach ($posts as $post) {
        echo '<h2>' . htmlspecialchars($post ['title']) . '</h2>';
        echo '<p>' . htmlspecialchars($post['content']) . '</p>';
        echo '<p>Posted by ' . htmlspecialchars($post['author']) . '</p>';
        echo '<a href="index.php?page=post&id=' . htmlspecialchars($post['id']) . '">Read more </a>';
        echo '<a href="index.php?page=edit_post&id=' . htmlspecialchars($post['id']) . '">Edit Post</a>';
    }
} catch (PDOException $e) {
    handleError($e);
}

?>

</body>
</html>