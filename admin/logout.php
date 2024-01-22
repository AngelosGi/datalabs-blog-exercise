<?php
require_once 'includes/error_handler.php'; 

try {
    session_start();
    session_destroy();
    header('Location: index.php');
    exit;
} catch (Exception $e) {
    handleError($e); 
}