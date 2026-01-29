<?php
session_start();
require_once "includes/config.php";

$order = null;
$error = "";

if (isset($_GET['code'])) {
    $code = trim($_GET['code']);

    $stmt = $conn->prepare("
        SELECT order_id, tracking_id, status, delivery_date
        FROM orders 
        WHERE order_id = ? OR tracking_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("ss", $code, $code);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        $error = "Order not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Track Order</title>
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

/* Card */
.track-card{
    max-width:480px;
    margin:80px auto;
    background:#fff;
    padding:35px 30px;
    border-radius:22px;
    box-shadow:0 25px 60px rgba(0,0,0,.15);
    text-align:center;
}

/* Title */
.track-card h2{
    font-size:30px;
    margin-bottom:20px;
    background:linear-gradient(135deg,var(--green),var(--orange));
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* Input */
.track-form input{
    width:100%;
    padding:14px 16px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    font-size:16px;
    outline:none;
    transition:.25s;
}

.track-form input:focus{
    border-color:var(--green);
    box-shadow:0 0 0 3px rgba(20,83,45,.15);
}

/* Button */
.track-form button{
    margin-top:14px;
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,var(--green),var(--orange));
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.track-form button:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(0,0,0,.25);
}

/* Status Box */
.status-box{
    margin-top:25px;
    background:linear-gradient(135deg,#ecfdf5,#fef3c7);
    border-radius:18px;
    padding:22px;
    text-align:left;
}

.status-box p{
    margin:8px 0;
    font-size:16px;
}

/* Status Badge */
.status-badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:999px;
    background:var(--green);
    color:#fff;
    font-size:14px;
    font-weight:600;
}

/* Error */
.error{
    margin-top:15px;
    color:#b91c1c;
    font-weight:600;
}

/* Actions */
.order-actions{
    margin-top:25px;
    display:flex;
    gap:12px;
}

.order-actions a{
    flex:1;
    padding:12px;
    border-radius:14px;
    text-decoration:none;
    font-weight:600;
    transition:.3s;
    text-align:center;
}

.btn-home{
    background:linear-gradient(135deg,var(--green),var(--orange));
    color:#fff;
}

.btn-cart{
    background:#e5e7eb;
    color:#111;
}

.order-actions a:hover{
    transform:translateY(-2px);
}
</style>
</head>

<body>

<div class="track-card">
    <h2>🔍 Track Your Order</h2>

    <form method="get" class="track-form">
        <input type="text" name="code" placeholder="Enter Order ID or Tracking ID" required>
        <button type="submit">Track Order</button>
    </form>

    <?php if ($error): ?>
        <div class="error">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($order): ?>
        <div class="status-box">
            <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?></p>
            <p><strong>Tracking ID:</strong> <?= htmlspecialchars($order['tracking_id']) ?></p>
            <p>
                <strong>Status:</strong>
                <span class="status-badge"><?= htmlspecialchars($order['status']) ?></span>
            </p>
            <p><strong>Delivery Date:</strong> <?= htmlspecialchars($order['delivery_date']) ?></p>
        </div>

        <div class="order-actions">
            <a href="cart.php" class="btn-cart">🛒 Back to Cart</a>
            <a href="index.php" class="btn-home">🏠 Back Home</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
