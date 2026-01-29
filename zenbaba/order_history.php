<?php
session_start();
require_once "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* FETCH USER ORDERS */
$orders = mysqli_query($conn, "
    SELECT order_id, created_at
    FROM orders
    WHERE user_id = '$user_id'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Order History</title>

<style>
body{
    font-family: Arial, Helvetica, sans-serif;
    background:#f4f6f8;
}

.container{
    width:90%;
    max-width:700px;
    margin:40px auto;
}

h2{
    text-align:center;
    margin-bottom:20px;
}

/* ACTION BUTTONS */
.actions{
    display:flex;
    justify-content:center;
    gap:15px;
    margin-bottom:25px;
}

.btn{
    padding:10px 18px;
    border-radius:6px;
    text-decoration:none;
    font-weight:bold;
    font-size:14px;
}

.btn.home{ background:#0a58ca; color:#fff; }
.btn.cart{ background:#198754; color:#fff; }
.btn.track{ background:#ffc107; color:#000; }

/* ORDER BOX */
.order-box{
    background:#fff;
    padding:18px;
    margin-bottom:15px;
    border-radius:8px;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

.order-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

.order-info{
    font-size:15px;
}
</style>
</head>

<body>

<div class="container">

<h2>📦 My Orders</h2>

<div class="actions">
    <a href="index.php" class="btn home">⬅ Back to Home</a>
    <a href="cart.php" class="btn cart">🛒 Back to Cart</a>
</div>

<?php
if (mysqli_num_rows($orders) == 0) {
    echo "<p style='text-align:center;'>You have no orders yet.</p>";
}
?>

<?php while ($order = mysqli_fetch_assoc($orders)) { ?>

<div class="order-box">
    <div class="order-row">
        <div class="order-info">
            <strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?><br>
            <strong>Date:</strong> <?= date("d M Y", strtotime($order['created_at'])) ?>
        </div>

        <a class="btn track"
           href="track_order.php?code=<?= urlencode($order['order_id']) ?>">
           🚚 Track Order
        </a>
    </div>
</div>

<?php } ?>

</div>

</body>
</html>









