<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

if (empty($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    die('Access denied.');
}

$showDeleted = isset($_GET['deleted']) && $_GET['deleted'] == '1';

$res = mysqli_query($conn, "SELECT id, name FROM tags ORDER BY name");
if ($res === false) {
    die('DB error: ' . mysqli_error($conn));
}

$tags = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Delete Tags</title>
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

        .alert {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            color: white;
            padding: 0.5rem;
            border: 1px solid #ccc;
        }

        .btn-delete {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Manage Tags</h1>

    <?php if ($showDeleted): ?>
        <div class="alert">✅ Tag deleted successfully.</div>
    <?php endif; ?>

    <?php if (count($tags) === 0): ?>
        <p>No tags in the database.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tags as $tag): ?>
                    <tr>
                        <td><?= htmlspecialchars($tag['name']) ?></td>
                        <td>
                            <form action="../backend/deleteTagLogic.php" method="post"
                                onsubmit="return confirm('Delete “<?= addslashes(htmlspecialchars($tag['name'])) ?>”?');">
                                <input type="hidden" name="tag_id" value="<?= $tag['id'] ?>">
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="../home.php" class="back-link" style="color:white;">← Back to Home</a>
</body>

</html>