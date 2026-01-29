<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "includes/config.php";

/* ---------- Currency ---------- */
$currency = $_SESSION['currency'] ?? 'USD';
$rate = 155; // 1 USD = 155 ETB

/* ---------- Add to Cart ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id  = (int)$_POST['id'];
    $qty = isset($_POST['qty']) ? max(1, (int)$_POST['qty']) : 1;
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
    header("Location: cart.php");
    exit;
}

/* ---------- Update Quantity (+ / -) ---------- */
if (isset($_GET['update'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        if ($_GET['update'] === 'plus') $_SESSION['cart'][$id]++;
        elseif ($_GET['update'] === 'minus' && $_SESSION['cart'][$id] > 1) $_SESSION['cart'][$id]--;
    }
    header("Location: cart.php");
    exit;
}

/* ---------- Remove Item ---------- */
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart | Zenbaba Market</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
body {
    font-family: 'Inter', Arial, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 20px;
}

/* CONTAINER */
.cart-container {
    max-width: 1000px;
    margin: 40px auto;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    padding: 30px;
}

/* HEADER */
.cart-container h2 {
    text-align: center;
    color: #14532d;
    margin-bottom: 30px;
    font-size: 32px;
}

/* TABLE */
.cart-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 15px;
}
.cart-table th, .cart-table td {
    padding: 15px;
    text-align: center;
    vertical-align: middle;
}
.cart-table th {
    background: #14532d;
    color: #fff;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
}
.cart-table tr {
    background: #fefefe;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}
.cart-table tr:hover {
    transform: translateY(-3px);
}
.cart-table img {
    width: 80px;
    border-radius: 10px;
    transition: transform 0.3s;
}
.cart-table img:hover { transform: scale(1.1); }

/* QTY BUTTONS */
.qty-btn {
    cursor: pointer;
    padding: 6px 12px;
    border-radius: 8px;
    background: linear-gradient(90deg,#fbbf24,#f59e0b);
    color: #14532d;
    font-weight: 600;
    margin: 0 5px;
    text-decoration: none;
    transition: 0.3s;
}
.qty-btn:hover {
    background: linear-gradient(90deg,#f59e0b,#fbbf24);
    color: #fff;
}

/* REMOVE */
.remove-btn {
    color: #ef4444;
    font-size: 18px;
    transition: 0.3s;
}
.remove-btn:hover { transform: scale(1.2); }

/* TOTAL ROW */
.total-row td {
    font-weight: 600;
    font-size: 18px;
}

/* BUTTONS */
.btn {
    display: inline-block;
    padding: 12px 35px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    background: linear-gradient(90deg,#14532d,#fbbf24);
    color: #fff;
    transition: 0.3s;
    margin: 10px 5px;
}
.btn:hover { transform: scale(1.05); opacity: 0.9; }
.btn-disabled {
    background: #ccc;
    cursor: not-allowed;
}

/* LINKS */
.center {
    text-align: center;
    margin: 25px 0;
    font-size: 14px;
}
.center a {
    color: #14532d;
    text-decoration: none;
    font-weight: 600;
}
.center a:hover { text-decoration: underline; }

/* EMPTY CART */
.empty-cart {
    font-size: 20px;
    text-align: center;
    margin: 50px 0;
}

/* ORDER HISTORY BUTTON */
.btn-history {
    display: inline-block;
    padding: 12px 30px;
    border-radius: 12px;
    background: linear-gradient(90deg,#fbbf24,#14532d);
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}
.btn-history:hover { transform: scale(1.05); opacity: 0.9; }
</style>
</head>
<body>

<div class="cart-container">
    <h2>🛒 Shopping Cart</h2>

    <?php if (empty($cart)): ?>
        <p class="empty-cart">Your cart is empty</p>
    <?php else: ?>
        <table class="cart-table">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price (<?= $currency ?>)</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Remove</th>
            </tr>

            <?php
            $ids = implode(",", array_keys($cart));
            $result = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");

            while ($p = mysqli_fetch_assoc($result)):
                $qty = $cart[$p['id']];
                $priceUSD = $p['price'];
                $price = ($currency === 'ETB') ? $priceUSD * $rate : $priceUSD;
                $sub = $price * $qty;
                $total += $sub;
            ?>
            <tr>
                <td><img src="assets/images/<?= htmlspecialchars($p['image']) ?>"></td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= number_format($price,2) ?></td>
                <td>
                    <a href="cart.php?update=minus&id=<?= $p['id'] ?>" class="qty-btn"><i class="fa-solid fa-minus"></i></a>
                    <?= $qty ?>
                    <a href="cart.php?update=plus&id=<?= $p['id'] ?>" class="qty-btn"><i class="fa-solid fa-plus"></i></a>
                </td>
                <td><?= number_format($sub,2) ?></td>
                <td><a href="?remove=<?= $p['id'] ?>" class="remove-btn"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
            <?php endwhile; ?>

            <tr class="total-row">
                <td colspan="4">TOTAL</td>
                <td><?= number_format($total,2) ?> <?= $currency ?></td>
                <td></td>
            </tr>
        </table>

        <div class="center">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a class="btn btn-disabled"><i class="fa-solid fa-lock"></i> Login required to Checkout</a><br><br>
                <a href="login.php">Login here</a>
            <?php else: ?>
                <a href="checkout.php" class="btn"><i class="fa-solid fa-credit-card"></i> Proceed to Checkout</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="center">
        <a href="index.php" class="btn"><i class="fa-solid fa-arrow-left"></i> Continue Shopping</a>
        <a href="order_history.php" class="btn-history"><i class="fa-solid fa-clock-rotate-left"></i> View Order History</a>
    </div>
</div>

</body>
</html>
