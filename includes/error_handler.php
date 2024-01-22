<?php
function handleError($exception) {
    echo "An error occurred: " . $exception->getMessage();
    // Log the error message and any other necessary information
    error_log($exception->getMessage());
    // You can also redirect to an error page
    // header('Location: error_page.php');
    exit();
}
?>