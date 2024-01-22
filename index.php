<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__);
}



session_start();
require_once 'includes/db.php';
require 'templates/header.php';


$page = $_GET['page'] ?? 'home'; // Default to 'home' if no page is specified

switch ($page) {
    case 'home':
        require ROOT_PATH . '/public/index.php';
        break;
    case 'post': 
        require ROOT_PATH . '/templates/post.php';
        break;
    case 'comment';
        require ROOT_PATH . '/public/add_comment.php';
        require ROOT_PATH . '/includes/functions.php';
        break;
    case 'login':
        require ROOT_PATH . '/public/login.php';
        break;
    case 'create_post':
        require ROOT_PATH . '/admin/create_post.php';
        break;
    case 'logout':
        require ROOT_PATH . '/admin/logout.php';
        break;
    case 'edit_post':
        require ROOT_PATH . '/admin/edit_post.php';
        break;
    // case 'delete_comment':
    //     require ROOT_PATH . '/admin/delete_comment.php';
    //     break;
    // Add more cases as needed...
    default:
        // I could show a 404 page here...
        echo "404 Page not found";
        break;
}
?>