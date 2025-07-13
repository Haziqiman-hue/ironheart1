<?php
session_start();
require 'db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

// Fetch all registered users
$stmt = $pdo->query("SELECT id, fullname, email, phone, membership_plan, role FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - IronHeartFitness</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      padding: 20px;
      background: #f4f4f4;
    }

    h1 {
      color: #2f00ff;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      background: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    th, td {
      border: 1px solid #ccc;
      padding: 14px;
      text-align: left;
    }

    th {
      background: #2f00ff;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .logout-btn {
      float: right;
      margin-top: 20px;
      padding: 10px 20px;
      background: #ff0000;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }

    .logout-btn:hover {
      background: #cc0000;
    }
  </style>
</head>
<body>
  <h1>Admin Dashboard</h1>

  <form action="logout.php" method="POST">
    <button type="submit" class="logout-btn">Logout</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Membership Plan</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['id']) ?></td>
          <td><?= htmlspecialchars($user['fullname']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['phone']) ?></td>
          <td><?= htmlspecialchars($user['membership_plan']) ?></td>
          <td><?= htmlspecialchars($user['role']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
