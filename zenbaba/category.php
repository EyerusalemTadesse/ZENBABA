<?php
include "includes/config.php";
include "data/products.php";
include "includes/header.php";

$category = $_GET['cat'] ?? '';
?>

<div class="layout">

    <?php include "includes/sidebar.php"; ?>

    <main class="content">
        <h2>
            <?php echo ucfirst(str_replace('_', ' ', $category)); ?>
        </h2>

        <div class="products">
            <?php foreach ($products as $product): ?>
                <?php if ($product['category'] === $category): ?>
                    <div class="product-card">

                        <img src="<?= BASE_URL ?>images/<?php echo $product['image']; ?>" alt="">

                        <h3><?php echo $product['name']; ?></h3>

                        <p class="price">
                            <?php echo formatPrice($product['price']); ?>
                        </p>

                        <form method="post" action="<?= BASE_URL ?>cart.php">
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="add">Add to Cart</button>
                        </form>

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php
        // If no products found
        $found = false;
        foreach ($products as $product) {
            if ($product['category'] === $category) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "<p>No products found in this category.</p>";
        }
        ?>

    </main>

</div>

<?php include "includes/footer.php"; ?>