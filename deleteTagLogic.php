<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

if (empty($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: deleteTag.php');
    exit;
}

if (empty($_POST['tag_id']) || !ctype_digit($_POST['tag_id'])) {
    die('Invalid tag ID.');
}
$tag_id = (int)$_POST['tag_id'];

if (!mysqli_query($conn, "DELETE FROM tags WHERE id = $tag_id")) {
    die('DB error: ' . mysqli_error($conn));
}

header('Location: ../admin/deleteTag.php');
exit;
?>