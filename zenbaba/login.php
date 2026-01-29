<?php
session_start();
require_once "includes/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if ($email === "" || $password === "") {
        $error = "Email and password are required.";
    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, email, phone, password, role 
             FROM users 
             WHERE email = ? 
             LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"]    = $user["id"];
                $_SESSION["user_name"]  = $user["name"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["user_phone"] = $user["phone"];
                $_SESSION["role"]       = $user["role"];

                if ($user["role"] === "admin") {
                    header("Location: admin/index.php");
                } else {
                    header("Location: index.php");
                }
                exit;

            } else {
                $error = "Invalid email or password.";
            }

        } else {
            $error = "Invalid email or password.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Zenbaba Market</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
/* BODY */
body {
    font-family: 'Inter', Arial, sans-serif;
    background: linear-gradient(135deg, #fbbf24, #14532d);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
}

/* BACK TO HOME */
.back-home {
    position: absolute;
    top: 20px;
    left: 20px;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}
.back-home:hover {
    color: #fbbf24;
    text-decoration: underline;
}

/* LOGIN CARD */
.login-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 400px;
    text-align: center;
    position: relative;
}

/* TITLE */
.login-card h2 {
    font-size: 28px;
    margin-bottom: 25px;
    color: #14532d;
}

/* ERROR */
.error { color: #ef4444; margin-bottom: 15px; }

/* FORM */
.login-card form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* INPUTS */
.login-card input {
    width: 100%;
    padding: 14px 12px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}
.login-card input:focus {
    border-color: #14532d;
    box-shadow: 0 0 8px rgba(20,83,45,0.4);
}

/* BUTTON */
.login-card button {
    padding: 14px 0;
    font-weight: 600;
    font-size: 16px;
    border: none;
    border-radius: 12px;
    color: #fff;
    cursor: pointer;
    background: linear-gradient(90deg,#14532d,#fbbf24);
    transition: 0.3s;
}
.login-card button:hover {
    opacity: 0.9;
    transform: scale(1.03);
}

/* LINKS */
.login-card p {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}
.login-card a {
    color: #14532d;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}
.login-card a:hover {
    text-decoration: underline;
}

/* RESPONSIVE */
@media(max-width:480px){
    .login-card{padding:30px 20px;}
    .login-card h2{font-size:24px;}
}
</style>
</head>
<body>

<!-- BACK TO HOME -->
<a href="index.php" class="back-home">← Back to Home</a>

<!-- LOGIN CARD -->
<div class="login-card">
    <h2>User Login</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>
</div>

</body>
</html>
