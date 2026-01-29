<?php
/* =========================
   ERROR REPORTING (DEV)
========================= */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* =========================
   SESSION START
========================= */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   DATABASE CONNECTION
========================= */
$conn = mysqli_connect("localhost", "root", "", "mywebsite_db");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

/* =========================
   CURRENCY SETTINGS
========================= */
define("USD_TO_ETB", 155);

if (!isset($_SESSION['currency'])) {
    $_SESSION['currency'] = 'USD';
}

// Set default language if not set
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Change language if requested
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    if (in_array($lang, ['en', 'am'])) {
        $_SESSION['lang'] = $lang;
    }
}



