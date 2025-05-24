<?php
session_start();
require_once '../partials/db.php';

if (empty($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    die('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: deletePost.php');
    exit;
}

$post_id = (int)($_POST['post_id'] ?? 0);

if ($post_id <= 0) {
    die('Invalid post ID.');
}

mysqli_query($conn, "DELETE FROM post_tags WHERE post_id = $post_id");

if (!mysqli_query($conn, "DELETE FROM posts WHERE id = $post_id")) {
    die('Failed to delete post: ' . mysqli_error($conn));
}

header('Location: deletePost.php?deleted=1');
exit;
