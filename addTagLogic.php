<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

if (empty($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    die('Access denied. Only admins can add tags.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/addTag.html');
    exit;
}

$tagName = trim($_POST['tag'] ?? '');
if ($tagName === '') {
    die('Error: Tag name is required.');
}

$escapedTag = mysqli_real_escape_string($conn, $tagName);

$checkSql = "SELECT id FROM tags WHERE name = '$escapedTag' LIMIT 1";
$checkRes = mysqli_query($conn, $checkSql);
if ($checkRes && mysqli_num_rows($checkRes) > 0) {
    die('Error: Tag already exists.');
}

$insertSql = "INSERT INTO tags (name) VALUES ('$escapedTag')";
if (!mysqli_query($conn, $insertSql)) {
    die('DB error: ' . mysqli_error($conn));
}

echo 'Tag added successfully!';
echo '<p><a href="../home.php">Back to Home</a></p>';
exit;
?>
