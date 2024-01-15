<?php 
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    echo 'You must be logged in as an admin to perform this action.';
    exit;
}