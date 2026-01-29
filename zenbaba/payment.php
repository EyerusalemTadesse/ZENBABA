<?php
session_start();
require_once "includes/config.php";

/* SECURITY */
if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

/* FORM DATA */
$delivery_date  = $_POST['delivery_date'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$phone          = $_POST['phone'] ?? null;

/* BASIC VALIDATION */
if ($payment_method === '') {
    die("❌ Please select a payment method.");
}

/* TOTAL */
$total = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    $res = $conn->query("SELECT price FROM products WHERE id=$pid");
    $p = $res->fetch_assoc();
    $total += $p['price'] * $qty;
}

/* IDS */
$order_id    = "ORD" . time();
$tracking_id = "TRK" . rand(100000,999999);
$user_id     = $_SESSION['user_id'];

/* INSERT ORDER */
$stmt = $conn->prepare("
    INSERT INTO orders 
    (order_id, tracking_id, user_id, total_amount, delivery_date, payment_method, phone, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')
");

$stmt->bind_param(
    "ssissss",
    $order_id,
    $tracking_id,
    $user_id,
    $total,
    $delivery_date,
    $payment_method,
    $phone
);

$stmt->execute();

/* CLEAR CART */
unset($_SESSION['cart']);

/* REDIRECT */
header("Location: order_success.php?order_id=$order_id");
exit;






