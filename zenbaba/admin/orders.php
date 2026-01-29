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

/* =========================
   UPDATE ORDER STATUS
========================= */
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status   = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
    $stmt->bind_param("ss", $status, $order_id);
    $stmt->execute();
}

/* =========================
   FETCH ORDERS
========================= */
$sql = "
SELECT
    o.order_id,
    o.tracking_id,
    o.delivery_date,
    o.status,

    u.name  AS user_name,
    u.email AS user_email,
    u.phone AS user_phone

FROM orders o
LEFT JOIN users u ON o.user_id = u.id
ORDER BY o.id DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin | Orders</title>
<style>
body {
    font-family: Arial, sans-serif;
    background:#f4f4f4;
}

/* ===== TOP BAR ===== */
.top-bar {
    display:flex;
    justify-content: space-between;
    align-items:center;
    padding:15px 25px;
    background:#0a58ca;
    color:#fff;
}
.top-bar h2 {
    margin:0;
}
.top-bar a {
    text-decoration:none;
    color:#fff;
    margin-left:12px;
    padding:8px 14px;
    background:#084298;
    border-radius:4px;
    font-weight:bold;
}
.top-bar a.logout {
    background:#dc3545;
}

/* ===== CONTENT ===== */
.container {
    width: 95%;
    margin: 30px auto;
    background: #fff;
    padding: 20px;
}

table {
    width:100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border:1px solid #ddd;
    text-align:center;
}
th {
    background:#0a58ca;
    color:#fff;
}

button {
    padding:6px 10px;
    background:#0a58ca;
    color:#fff;
    border:none;
    cursor:pointer;
}
select {
    padding:5px;
}
</style>
</head>
<body>

<!-- ===== TOP BAR ===== -->
<div class="top-bar">
    <h2>📦 Orders Management</h2>
    <div>
        <a href="../index.php">🏠 Home</a>
        <a href="../logout.php" class="logout">🚪 Logout</a>
    </div>
</div>

<div class="container">

<table>
<tr>
    <th>Order ID</th>
    <th>Tracking ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Delivery Date</th>
    <th>Status</th>
    <th>Update</th>
</tr>

<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['order_id']) ?></td>
    <td><?= htmlspecialchars($row['tracking_id']) ?></td>
    <td><?= htmlspecialchars($row['user_name'] ?? 'Guest') ?></td>
    <td><?= htmlspecialchars($row['user_email'] ?? '—') ?></td>
    <td><?= htmlspecialchars($row['user_phone'] ?? '—') ?></td>
    <td><?= $row['delivery_date'] ?: '—' ?></td>
    <td><strong><?= htmlspecialchars($row['status']) ?></strong></td>

    <td>
        <form method="post">
            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
            <select name="status">
                <option value="Pending" <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
                <option value="Processing" <?= $row['status']=='Processing'?'selected':'' ?>>Processing</option>
                <option value="Shipped" <?= $row['status']=='Shipped'?'selected':'' ?>>Shipped</option>
                <option value="Delivered" <?= $row['status']=='Delivered'?'selected':'' ?>>Delivered</option>
            </select>
            <br><br>
            <button type="submit" name="update_status">Save</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="8">No orders found</td>
</tr>
<?php endif; ?>

</table>
</div>

</body>
</html>



