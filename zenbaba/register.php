<?php
require_once "includes/config.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name             = trim($_POST["name"]);
    $email            = trim($_POST["email"]);
    $password         = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $phone            = trim($_POST["phone"]);

    if ($name === "" || $email === "" || $phone === "" || $password === "" || $confirm_password === "") {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered.";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = "user";

            $stmt = $conn->prepare(
                "INSERT INTO users (name,email,phone,password,role)
                 VALUES (?,?,?,?,?)"
            );
            $stmt->bind_param("sssss", $name, $email, $phone, $hash, $role);
            $stmt->execute();

            $success = "Registration successful. You can login.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | Zenbaba Market</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
/* BODY & BACKGROUND */
body {
    font-family: 'Inter', Arial, sans-serif;
    background: linear-gradient(135deg, #fbbf24, #14532d);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 20px;
}

/* BACK TO HOME LINK */
.back-home {
    margin-bottom: 25px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    transition: 0.3s;
}
.back-home:hover {
    color: #fbbf24;
    text-decoration: underline;
}

/* CARD */
.register-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 420px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

/* CARD TITLE */
.register-card h2 {
    font-size: 28px;
    margin-bottom: 25px;
    color: #14532d;
}

/* MESSAGES */
.msg { color: #ef4444; margin-bottom: 15px; }
.success { color: #16a34a; margin-bottom: 15px; }

/* FORM */
.register-card form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    position: relative;
}

/* FLOATING LABEL EFFECT */
.register-card input {
    width: 100%;
    padding: 14px 12px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}
.register-card input:focus {
    border-color: #14532d;
    box-shadow: 0 0 8px rgba(20,83,45,0.4);
}

/* BUTTON */
.register-card button {
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
.register-card button:hover {
    opacity: 0.9;
    transform: scale(1.03);
}

/* LINKS */
.register-card p {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}
.register-card a {
    color: #14532d;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s;
}
.register-card a:hover {
    text-decoration: underline;
}

/* RESPONSIVE */
@media(max-width:480px){
    .register-card{padding:30px 20px;}
    .register-card h2{font-size:24px;}
}
</style>
</head>
<body>

<!-- BACK TO HOME -->
<a href="index.php" class="back-home">← Back to Home</a>

<!-- REGISTRATION CARD -->
<div class="register-card">
    <h2>User Registration</h2>

    <?php if($error): ?><p class="msg"><?= $error ?></p><?php endif; ?>
    <?php if($success): ?><p class="success"><?= $success ?></p><?php endif; ?>

    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>
        <button>Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
