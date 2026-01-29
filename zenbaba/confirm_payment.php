<?php
session_start();
require_once "includes/config.php";

$order_id = $_POST['order_id'] ?? '';
$method   = $_POST['payment_method'] ?? '';

if ($order_id === '' || $method === '') {
    die("Invalid request");
}

$stmt = $conn->prepare(
    "UPDATE orders SET payment_method=? WHERE order_id=?"
);
$stmt->bind_param("ss", $method, $order_id);
$stmt->execute();

header("Location: track_order.php?order_id=$order_id");
exit;
