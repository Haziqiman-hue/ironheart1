<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $password = $_POST['password'];  

    $stmt = $pdo->prepare("SELECT * FROM users WHERE fullname = ?");
    $stmt->execute([$fullname]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        exit();
    } else {
        echo "<script>alert('❌ Invalid Full Name or Password'); window.location.href='login.html';</script>";
    }
}
?>
