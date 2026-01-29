<?php
require_once "includes/config.php";

/* User must be logged in */
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

/* Admins not allowed here */
if ($_SESSION["role"] === "admin") {
    header("Location: admin/index.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT name, email FROM users WHERE id=? LIMIT 1"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>
<style>
body{font-family:Arial;background:#f4f4f4}
.profile{width:400px;margin:80px auto;background:#fff;padding:25px}
h2{text-align:center}
.info{margin:10px 0}
.logout{display:block;text-align:center;margin-top:15px;color:red}
</style>
</head>
<body>

<div class="profile">
<h2>My Profile</h2>

<div class="info"><strong>Name:</strong> <?= htmlspecialchars($user["name"]) ?></div>
<div class="info"><strong>Email:</strong> <?= htmlspecialchars($user["email"]) ?></div>
<div class="info"><strong>Role:</strong> User</div>

<a class="logout" href="logout.php">Logout</a>
</div>

</body>
</html>
