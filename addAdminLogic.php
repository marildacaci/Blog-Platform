<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

$roleName = $_SESSION['user_role'] ?? '';
$roleId   = $_SESSION['user_role_id'] ?? null;

if (!((is_string($roleName) && strtolower($roleName) === 'admin') || ($roleId !== null && (int)$roleId === 1))) {
    die('Access denied. Only admins can promote users.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/addAdmin.html');
    exit;
}

$identifier = trim($_POST['email_or_username'] ?? '');
if ($identifier === '') {
    die('Error: You must enter an email or username.');
}

$identifierEsc = mysqli_real_escape_string($conn, $identifier);
$sql = "SELECT id, username, email FROM users WHERE username = '$identifierEsc' OR email = '$identifierEsc' LIMIT 1";
$res = mysqli_query($conn, $sql);

if (! $res || mysqli_num_rows($res) === 0) {
    die('Error: User not found.');
}

$user = mysqli_fetch_assoc($res);
$userId = (int)$user['id'];

$r = mysqli_query($conn, "SELECT id FROM roles WHERE LOWER(name) = 'admin' LIMIT 1");
if (! $r || mysqli_num_rows($r) === 0) {
    die('Error: Admin role not configured.');
}
$row = mysqli_fetch_assoc($r);
$adminRole = (int)$row['id'];

$upd = "UPDATE users SET role_id = $adminRole WHERE id = $userId";
if (! mysqli_query($conn, $upd)) {
    die('Error updating role: ' . mysqli_error($conn));
}

echo '<h2>Current Administrators</h2>';
$qa = "SELECT u.username, u.email FROM users u
      JOIN roles r ON u.role_id = r.id
      WHERE LOWER(r.name) = 'admin'";

$ra = mysqli_query($conn, $qa);
if ($ra && mysqli_num_rows($ra) > 0) {
    echo '<ul>';
    while ($a = mysqli_fetch_assoc($ra)) {
        echo '<li>' . htmlspecialchars($a['username']) . ' (' . htmlspecialchars($a['email']) . ')' . '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No admins found.</p>';
}

echo '<p><a href="../home.php">Back to Home</a></p>';
exit;
?>
