<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE fullname = ? AND role = 'admin'");
    $stmt->execute([$fullname]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['fullname'] = $admin['fullname'];
        $_SESSION['role'] = 'admin';

        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('❌ Invalid admin credentials'); window.location.href='admin_login.html';</script>";
    }
}
?>
