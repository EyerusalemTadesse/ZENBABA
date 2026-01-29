<?php
require_once "includes/config.php";
require_once "includes/header.php";

/* Category filter */
$where = "";
if (isset($_GET['cat'])) {
    $cat_id = (int)$_GET['cat'];
    $where = "WHERE category_id = $cat_id";
}

/* Get products */
$products = mysqli_query($conn, "SELECT * FROM products $where");
?>

<div class="page-layout">

    <!-- SIDEBAR -->
    <?php include "includes/sidebar.php"; ?>

    <!-- PRODUCTS -->
    <div class="container">
        <h2>Our Products</h2>

        <div class="product-grid">
            <?php while ($p = mysqli_fetch_assoc($products)) { ?>
                <div class="product-card">
                    <img src="assets/images/<?php echo $p['image']; ?>" width="150">
                    <h3><?php echo $p['name']; ?></h3>
                    <p><?php echo $p['price']; ?> USD</p>
                </div>
            <?php } ?>
        </div>
    </div>

</div>

<?php require_once "includes/footer.php"; ?>




