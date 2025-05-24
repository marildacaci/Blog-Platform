<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

if (empty($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    die('Access denied.');
}

$query = "SELECT id, title FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Delete Posts</title>
    <!--<link rel="stylesheet" href="../public/styles/style.css" />-->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(-45deg, #6196ca, #9769c2, #d999b9, #eed6a9);
            animation: gradientBG 15s ease infinite;
        }

        h1 {
            text-align: center;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            color: white;
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .delete-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            color: white;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Delete Posts</h1>

        <?php if (isset($_GET['deleted'])): ?>
            <p style="color: lightgreen;">Post deleted successfully.</p>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($post = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $post['id'] ?></td>
                            <td><?= htmlspecialchars($post['title']) ?></td>
                            <td>
                                <form action="../backend/deletePostLogic.php" method="post" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>" />
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No posts found.</p>
        <?php endif; ?>
        <a href="../home.php" class="back-link">← Back to Home</a>
    </div>
</body>

</html>