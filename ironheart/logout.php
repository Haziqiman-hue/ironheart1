<?php
session_start();
session_destroy();
header('Location: index.html');
exit();
?>

<?php
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT r.*, s.name AS service FROM reservations r JOIN services s ON r.service_id = s.id WHERE r.user_id = ? ORDER BY r.date, r.time");
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll();
?>

<h2>My Bookings</h2>
<ul>
<?php foreach ($reservations as $r): ?>
    <li><?= $r['service'] ?> - <?= $r['date'] ?> at <?= $r['time'] ?></li>
<?php endforeach; ?>
</ul>
<a href="logout.php">Logout</a>

<?php
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html');
    exit();
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: admin_dashboard.php');
    exit();
}

$stmt = $pdo->query("SELECT r.*, u.fullname, s.name AS service FROM reservations r JOIN users u ON r.user_id = u.id JOIN services s ON r.service_id = s.id ORDER BY r.date, r.time");
$reservations = $stmt->fetchAll();
?>

<h2>All Bookings</h2>
<table border="1">
<tr><th>User</th><th>Service</th><th>Date</th><th>Time</th><th>Action</th></tr>
<?php foreach ($reservations as $r): ?>
<tr>
  <td><?= $r['fullname'] ?></td>
  <td><?= $r['service'] ?></td>
  <td><?= $r['date'] ?></td>
  <td><?= $r['time'] ?></td>
  <td><a href="?delete=<?= $r['id'] ?>" onclick="return confirm('Delete booking?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
<a href="logout.php">Logout</a>
