<?php
require_once "../includes/config.php";

if (!isset($_GET['id'])) {
    die("Product ID missing");
}

$id = (int)$_GET['id'];

/* Optional: delete image file too */
$product = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT image FROM products WHERE id=$id")
);

if ($product && file_exists("../assets/images/" . $product['image'])) {
    unlink("../assets/images/" . $product['image']);
}

/* Delete product from DB */
mysqli_query($conn, "DELETE FROM products WHERE id=$id");

header("Location: index.php");
exit;
