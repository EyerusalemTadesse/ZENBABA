<?php
require_once "includes/config.php";

/* Destroy all session data */
$_SESSION = [];
session_unset();
session_destroy();

/* Redirect to login */
header("Location: login.php");
exit;
