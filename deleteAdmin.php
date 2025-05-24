<?php
session_start();
require_once __DIR__ . '/../partials/db.php';

if (empty($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
    die('Access denied.');
}

$currentUserId = (int) ($_SESSION['user_id'] ?? 0);
$sql = "SELECT u.id, u.username, u.email
       FROM users u
       JOIN roles r ON u.role_id = r.id
       WHERE LOWER(r.name) = 'admin' AND u.id != $currentUserId
       ORDER BY u.username";

$res = mysqli_query($conn, $sql);
if ($res === false) {
    die('DB error: ' . mysqli_error($conn));
}

$admins = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Admins</title>
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
            margin: 1rem 0;
        }

        th,
        td {
            color: white;
            padding: 0.5rem;
            border: 1px solid #ccc;
        }

        .btn-demote {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .alert {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin: 1rem 0;
        }
    </style>
</head>

<body>
    <main style="flex:1; overflow-y:auto; padding:2rem;">
        <h1>Manage Admins</h1>

        <?php if (isset($_GET['demoted']) && $_GET['demoted'] == '1'): ?>
            <div class="alert">✅ Admin demoted successfully.</div>
        <?php endif; ?>

        <?php if (empty($admins)): ?>
            <p>No other admins found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $adm): ?>
                        <tr>
                            <td><?= htmlspecialchars($adm['id']) ?></td>
                            <td><?= htmlspecialchars($adm['username']) ?></td>
                            <td><?= htmlspecialchars($adm['email']) ?></td>
                            <td style="text-align:center;">
                                <form action="../backend/deleteAdminLogic.php" method="post"
                                    onsubmit="return confirm('Demote <?= addslashes(htmlspecialchars($adm['username'])) ?> from admin?');">
                                    <input type="hidden" name="user_id" value="<?= $adm['id'] ?>">
                                    <button type="submit" class="btn-demote">Demote</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a href="../home.php" class="back-link" style="color: white;">← Back to Home</a>
    </main>
</body>

</html>