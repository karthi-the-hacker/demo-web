<?php
session_start();

$valid_username = 'cappriciosec';
$valid_password = 'cappriciosec@123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    if ($entered_username === $valid_username && $entered_password === $valid_password) {
        $_SESSION['logged_in'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
