<?php 
require_once '../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Username and password are required';
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
                echo 'Invalid Username or Password';
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
}
?>

<!-- Display error message -->
<?php if (!empty($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>


<form method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Login">
</form>