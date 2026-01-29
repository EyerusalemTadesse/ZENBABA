<?php
session_start();
require_once "../includes/config.php";

/* =========================
   ADMIN AUTH PROTECTION
========================= */
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 6px;
        }
        h1 {
            margin-bottom: 10px;
        }
        .nav a {
            display: inline-block;
            margin: 10px 10px 0 0;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .nav a.logout {
            background: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION["user_name"]); ?></strong></p>

    <div class="nav">
        <a href="products.php">📦 Manage Products</a>
        <a href="categories.php">📂 Manage Categories</a>
        <a href="orders.php">🧾 View Orders</a>
        <a href="../logout.php" class="logout">🚪 Logout</a>
    </div>
</div>

</body>
</html>


