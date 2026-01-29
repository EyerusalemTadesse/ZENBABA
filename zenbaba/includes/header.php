<?php
// ✅ Start session only if not already started
if (session_status() === PHP_SESSION_NONE) session_start();

require_once "config.php";
require_once "lang.php"; // Must be included after session_start

$user_id = $_SESSION['user_id'] ?? null;
$currentPage = $_SERVER['REQUEST_URI'];
?>

<header class="main-header">

    <!-- LEFT: Logo + Currency -->
    <div class="header-left">
        <a href="index.php" class="logo-link">
            <img src="assets/images/logo.png" alt="Zenbaba Market" class="logo">
        </a>
        <div class="currency-toggle">
            <a href="includes/switch_currency.php?currency=USD&redirect=<?php echo urlencode($currentPage); ?>" class="<?php echo ($_SESSION['currency'] ?? '')==='USD'?'active':''; ?>">USD</a>
            <span>|</span>
            <a href="includes/switch_currency.php?currency=ETB&redirect=<?php echo urlencode($currentPage); ?>" class="<?php echo ($_SESSION['currency'] ?? '')==='ETB'?'active':''; ?>">ETB</a>
        </div>
    </div>

    <!-- CENTER: Logo + Search -->
    <div class="header-center">
        <form method="get" action="index.php" class="search-bar">
            <input type="text" name="search" placeholder="<?php echo t('search_placeholder'); ?>" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            <button type="submit"><?php echo t('search_button'); ?></button>
        </form>
    </div>

    <!-- RIGHT: Cart + Auth + Language -->
    <div class="header-right">
        <a href="cart.php" class="cart-link">🛒 <?php echo t('cart'); ?></a>
        <?php if($user_id): ?>
            <a href="logout.php" class="user-menu"><?php echo t('logout'); ?></a>
        <?php else: ?>
            <a href="login.php" class="user-menu"><?php echo t('login'); ?></a>
            <a href="register.php" class="user-menu"><?php echo t('register'); ?></a>
        <?php endif; ?>
        <div class="lang-toggle">
            <a href="includes/switch_language.php?lang=en&redirect=<?php echo urlencode($currentPage); ?>" class="<?php echo ($_SESSION['lang'] ?? '')==='en'?'active':''; ?>">EN</a>
            <span>|</span>
            <a href="includes/switch_language.php?lang=am&redirect=<?php echo urlencode($currentPage); ?>" class="<?php echo ($_SESSION['lang'] ?? '')==='am'?'active':''; ?>">አማ</a>
        </div>
    </div>

</header>
