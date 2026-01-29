<?php
session_start();

/* VALIDATE LANGUAGE */
$allowed = ['en', 'am'];

$lang = $_GET['lang'] ?? 'en';
if (!in_array($lang, $allowed)) {
    $lang = 'en';
}

/* STORE LANGUAGE */
$_SESSION['lang'] = $lang;

/* REDIRECT SAFELY */
$redirect = $_GET['redirect'] ?? '/mywebsite/index.php';

/* SECURITY: prevent external redirect */
if (strpos($redirect, '/') !== 0) {
    $redirect = '/mywebsite/index.php';
}

header("Location: $redirect");
exit;
