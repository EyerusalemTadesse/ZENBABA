<?php
session_start();

if (isset($_GET['currency'])) {
    if ($_GET['currency'] === 'USD' || $_GET['currency'] === 'ETB') {
        $_SESSION['currency'] = $_GET['currency'];
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

