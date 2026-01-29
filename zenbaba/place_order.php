<?php
session_start();
require_once "includes/config.php";

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$currency = $_SESSION['currency'] ?? 'USD';
$rate = 55;

/* IDs */
$order_id    = "ORD" . time();
$tracking_id = "TRK" . rand(100000, 999999);

/* User */
$user_id = $_SESSION['user_id'] ?? NULL;
$email = NULL;
$phone = NULL;

/* Get user email & phone if logged in */
if ($user_id) {
    $stmt = $conn->prepare("SELECT email, phone FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $u = $stmt->get_result()->fetch_assoc();

    $email = $u['email'];
    $phone = $u['phone'];
}

/* Calculate total */
$total = 0;
$delivery_fee = 40.00;

$ids = implode(",", array_keys($_SESSION['cart']));
$result = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");

while ($p = mysqli_fetch_assoc($result)) {
    $price = ($currency === 'ETB') ? $p['price'] * $rate : $p['price'];
    $qty = $_SESSION['cart'][$p['id']];
    $total += $price * $qty;
}

/* Order info */
$status = "Pending";
$payment_method = "cash";
$delivery_date = date("Y-m-d");

/* INSERT ORDER — FIXED */
$stmt = $conn->prepare("
    INSERT INTO orders 
    (order_id, tracking_id, total_amount, user_id, payment_method,
     delivery_date, status, delivery_fee, email, phone)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssdisssdss",
    $order_id,
    $tracking_id,
    $total,
    $user_id,
    $payment_method,
    $delivery_date,
    $status,
    $delivery_fee,
    $email,
    $phone
);

$stmt->execute();

/* Save order items */
foreach ($_SESSION['cart'] as $pid => $qty) {
    $p = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT price FROM products WHERE id=$pid")
    );

    $price = ($currency === 'ETB') ? $p['price'] * $rate : $p['price'];

    mysqli_query($conn, "
        INSERT INTO order_items (order_id, product_id, price, quantity)
        VALUES ('$order_id', $pid, $price, $qty)
    ");
}

/* Clear cart */
unset($_SESSION['cart']);

header("Location: payment.php?order_id=$order_id");
exit;

