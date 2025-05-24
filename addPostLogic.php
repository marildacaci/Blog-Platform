<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

if (empty($_SESSION['user_id'])) {
    header('Location: ../authentification/login.php');
    exit;
}
$user_id = (int) $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../addPost.html');
    exit;
}

$title = trim($_POST['title'] ?? '');
$tag_id = trim($_POST['tag'] ?? '');
$path = trim($_POST['path'] ?? '');
$content = trim($_POST['content'] ?? '');

if ($title === '' || $tag_id === '' || $content === '') {
    die('Error: title, tag, and content are required.');
}

$eTitle = mysqli_real_escape_string($conn, $title);
$ePath = mysqli_real_escape_string($conn, $path);
$eContent = mysqli_real_escape_string($conn, $content);
$tag_id = (int) $tag_id;

$sql = sprintf("INSERT INTO posts (user_id, title, first_image, first_paragraph, created_at) VALUES (%d, '%s', '%s', '%s', NOW())",
    $user_id, $eTitle, $ePath, $eContent);
if (!mysqli_query($conn, $sql)) {
    die('DB error (posts): ' . mysqli_error($conn));
}

$post_id = mysqli_insert_id($conn);
if (!$post_id) {
    die('Failed to retrieve new post ID');
}

$sql2 = sprintf("INSERT INTO post_tags (post_id, tag_id) VALUES (%d, %d)", $post_id, $tag_id);
if (!mysqli_query($conn, $sql2)) {
    die('DB error (post_tags): ' . mysqli_error($conn));
}

echo 'Post added successfully!';
echo '<p><a href="../home.php">Back to Home</a></p>';
exit;
?>