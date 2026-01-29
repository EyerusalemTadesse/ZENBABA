<?php
session_start();
require_once "../includes/config.php";

/* Admin protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

/* Add category */
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
}

/* Delete category */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id=$id");
}

$cats = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Categories</title>
<style>
body{font-family:Arial;background:#f4f4f4}
.box{width:400px;margin:50px auto;background:#fff;padding:20px}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border:1px solid #ddd;text-align:center}
th{background:#0a58ca;color:#fff}
</style>
</head>
<body>

<div class="box">
<h2>📂 Manage Categories</h2>

<form method="post">
    <input name="name" placeholder="Category Name" required>
    <button name="add">Add</button>
</form>

<br>

<table>
<tr>
    <th>Name</th>
    <th>Delete</th>
</tr>

<?php while($c=$cats->fetch_assoc()): ?>
<tr>
    <td><?= $c['name'] ?></td>
    <td>
        <a href="?delete=<?= $c['id'] ?>" onclick="return confirm('Delete?')">❌</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>
