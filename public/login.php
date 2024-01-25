<?php 

require_once './includes/db.php';
require_once './includes/functions.php';

//NEXT STEP
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        handleError(new Exception('Username and password are required'));
    } else {
        try {
            $sql = 'SELECT * FROM admin WHERE username = ?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                session_start();
                $_SESSION['admin_logged_in'] = true;

                header('Location: index.php');
                exit;
            } else {
                handleError(new Exception('Invalid Username or Password'));
            }
        } catch (PDOException $e) {
            handleError($e);
        }
    }
    
}
?>


<!-- Login Form -->
<div class="mx-auto max-w-xl px-4 py-8"> <!-- Start of Tailwind CSS container for the form -->
<form method="post" class="space-y-4">
    <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
    <input type="text" id="username" name="username" required class="block w-full px-4 py-2 border border-gray-300 rounded">
    <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
    <input type="password" id="password" name="password" required class="block w-full px-4 py-2 border border-gray-300 rounded">
    <input type="submit" value="Login" class="px-4 py-2 bg-blue-500 text-white rounded">
</form>
</div>