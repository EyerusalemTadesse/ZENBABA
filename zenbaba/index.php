<?php
require_once "includes/config.php"; // $conn
require_once "includes/lang.php";   // translation file
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?? 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <title>Zenbaba Market</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php require_once "includes/header.php"; ?>

<?php
/* FILTERS */
$where = [];
if (isset($_GET['cat'])) $where[] = "category_id=".(int)$_GET['cat'];

$search = '';
if(!empty($_GET['search'])){
    $search = mysqli_real_escape_string($conn,$_GET['search']);
    $where[] = "name LIKE '%$search%'";
}

$whereSQL = $where ? "WHERE ".implode(" AND ",$where) : "";

/* FETCH PRODUCTS */
$products = mysqli_query($conn,"SELECT * FROM products $whereSQL");
if(!$products) die("Query failed: ".mysqli_error($conn));

/* FETCH CATEGORIES */
$categories = mysqli_query($conn,"SELECT * FROM categories");
if(!$categories) die("Query failed: ".mysqli_error($conn));
?>

<!-- HERO -->
<div class="hero-banner">
    <img src="assets/images/hero.png" alt="Zenbaba Market" class="hero-img">
    <div class="hero-text">
        <h1><?php echo t('welcome_message'); ?></h1>
        <p><?php echo t('hero_subtitle'); ?></p>
        <a href="#our-products" class="btn-primary"><?php echo t('shop_now'); ?></a>
    </div>
</div>

<!-- MAIN + SIDEBAR FIXED -->
<div class="page-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h3><?php echo t('categories'); ?></h3>
        <ul>
            <li><a href="index.php#our-products"><?php echo t('all'); ?></a></li>
            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                <li><a href="index.php?cat=<?php echo $cat['id']; ?>#our-products"><?php echo htmlspecialchars($cat['name']); ?></a></li>
            <?php endwhile; ?>
        </ul>
    </aside>

    <!-- PRODUCTS -->
    <main id="our-products"class="container">
        <h2 class="section-title"><?php echo t('our_products'); ?></h2>
        <?php if($search): ?>
            <p class="search-info"><?php echo t('showing_results'); ?> <strong><?php echo htmlspecialchars($search); ?></strong></p>
        <?php endif; ?>

        <div class="product-grid">
            <?php if(mysqli_num_rows($products) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($products)): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="assets/images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p class="price">
                            <?php 
                                if($_SESSION['currency']==='USD'){ 
                                    echo number_format($row['price'],2)." USD"; 
                                } else { 
                                    echo number_format($row['price']*USD_TO_ETB,2)." ETB"; 
                                } 
                            ?>
                        </p>
                        <form method="post" action="cart.php" class="add-cart-form">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="number" name="qty" value="1" min="1">
                            <button type="submit"><?php echo t('add_to_cart'); ?></button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-results"><?php echo t('no_products_found'); ?></p>
            <?php endif; ?>
        </div>
    </main>

</div>

<!-- ABOUT -->
<a href="stories.php" class="about-link">
    <div class="about-section">
        <h2><?php echo t('our_story'); ?></h2>
        <p><strong><?php echo t('about_text'); ?></strong></p>
    </div>
</a>


<?php include 'includes/footer.php'; ?>

</body>
</html>
