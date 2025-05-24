<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

if (empty($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: deleteAdmin.php');
    exit;
}

if (empty($_POST['user_id']) || !ctype_digit($_POST['user_id'])) {
    die('Invalid user ID.');
}
$user_id = (int) $_POST['user_id'];

$resRole = mysqli_query($conn, "SELECT id FROM roles WHERE LOWER(name) = 'user' LIMIT 1");
if (!$resRole || mysqli_num_rows($resRole) === 0) {
    die('User role not configured.');
}
$row = mysqli_fetch_assoc($resRole);
$userRoleId = (int) $row['id'];

$sql = "UPDATE users SET role_id = $userRoleId WHERE id = $user_id";
if (!mysqli_query($conn, $sql)) {
    die('DB error: ' . mysqli_error($conn));
}

header('Location: ../admin/deleteAdmin.php');
exit;
?>