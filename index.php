<?php
define('ROOT_PATH', __DIR__);
session_start();
require 'includes/db.php';?>

<?php
$page = $_GET['page'] ?? 'home'; // Default to 'home' if no page is specified

switch ($page) {
    case 'home':
        require 'public/index.php';
        break;
    case 'login':
        require 'public/login.php';
        break;
    case 'add_post':
        require 'admin/add_post.php';
        break;
    case 'post':
        require ROOT_PATH . '/public/post.php';
        break;
    case 'logout':
        require ROOT_PATH . '/admin/logout.php';
    case 'delete':
        require ROOT_PATH . '/admin/delete_post.php';
    break;
    // Add more cases as needed...
    default:
        // You could show a 404 page here...
        echo "Page not found";
        break;
}
?>