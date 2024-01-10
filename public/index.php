<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
</head>
<body>

<?php include '../templates/header.php'; ?>

    <h1>Welcome to My Blog</h1>

    <!-- posts will be here -->
<div class="post">
    <h2>Post Title</h2>
    <p>Post Content</p>
    <p>Author: John Doe | Date: 2022-02-22</p>
    <img src="path/to/image">
    <div class="comments">
        <h3>Comments:</h3>
        <div class="comment">
            <p>John: This is a comment!</p>
            <p>Date: 2022-02-22</p>
        </div>
        <!-- More comments as necessary -->
    </div>    
</div>

</body>
</html>