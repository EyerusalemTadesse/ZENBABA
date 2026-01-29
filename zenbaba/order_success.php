<?php
session_start();
require_once "includes/config.php";

/* 1️⃣ Try session first */
if (isset($_SESSION['last_order'])) {
    $order = $_SESSION['last_order'];
    unset($_SESSION['last_order']);
}
/* 2️⃣ Fallback: load from DB using order_id */
elseif (isset($_GET['order_id'])) {
    $oid = $_GET['order_id'];

    $stmt = $conn->prepare("
        SELECT order_id, tracking_id, delivery_date, status
        FROM orders
        WHERE order_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("s", $oid);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        die("Invalid order.");
    }

    $order = $res->fetch_assoc();
}
else {
    die("Invalid order.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Success</title>
<style>
:root{
    --green:#14532d;
    --green-dark:#064e3b;
    --orange:#f59e0b;
    --bg:#f4f6f8;
}

body{
    margin:0;
    font-family:'Segoe UI',system-ui,-apple-system,sans-serif;
    background:var(--bg);
}

.success-card{
    max-width:480px;
    margin:80px auto;
    background:#fff;
    padding:35px 30px;
    border-radius:22px;
    box-shadow:0 25px 60px rgba(0,0,0,.15);
    text-align:center;
}

/* Success icon and title */
.success-card h2{
    font-size:28px;
    margin-bottom:18px;
    background:linear-gradient(135deg,var(--green),var(--orange));
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* Order details */
.order-details{
    text-align:left;
    margin-top:20px;
    padding:15px 20px;
    background:linear-gradient(135deg,#ecfdf5,#fef3c7);
    border-radius:18px;
}

.order-details p{
    font-size:16px;
    margin:8px 0;
}

.status-badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:999px;
    background:var(--green);
    color:#fff;
    font-weight:600;
    font-size:14px;
}

/* Buttons */
.action-buttons{
    margin-top:25px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    justify-content:center;
}

.action-buttons a{
    flex:1 1 45%;
    padding:14px 16px;
    border-radius:14px;
    text-decoration:none;
    font-weight:600;
    text-align:center;
    transition:.3s;
}

.btn-primary{
    background:linear-gradient(135deg,var(--green),var(--orange));
    color:#fff;
}

.btn-secondary{
    background:#e5e7eb;
    color:#111;
}

.action-buttons a:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(0,0,0,.2);
}
</style>
</head>

<body>

<div class="success-card">
    <h2>✅ Order Placed Successfully!</h2>

    <div class="order-details">
        <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?></p>
        <p><strong>Tracking ID:</strong> <?= htmlspecialchars($order['tracking_id']) ?></p>
        <p><strong>Delivery Date:</strong> <?= htmlspecialchars($order['delivery_date']) ?></p>
        <p><strong>Status:</strong> <span class="status-badge"><?= htmlspecialchars($order['status']) ?></span></p>
    </div>

    <div class="action-buttons">
        <a class="btn-primary" href="track_order.php?code=<?= $order['order_id'] ?>">🔍 Track Order</a>
        <a class="btn-secondary" href="cart.php">🛒 Back to Cart</a>
        <a class="btn-primary" href="index.php">🏠 Back to Home</a>
    </div>
</div>

</body>
</html>
