<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $membership_plan = $_POST['membership_plan'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    try {
        $stmt = $pdo->prepare("INSERT INTO users (fullname, email, phone, membership_plan, password, role) VALUES (?, ?, ?, ?, ?, 'user')");
        $stmt->execute([$fullname, $email, $phone, $membership_plan, $password]);

        echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
        exit();
    } catch (PDOException $e) {
        echo "❌ Registration error: " . $e->getMessage();
    }
} else {
    echo "⛔ Invalid request method";
}
?>
