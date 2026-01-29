<?php
session_start();
require_once "includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

date_default_timezone_set('Africa/Addis_Ababa');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:#f3f4f6;
}

/* CONTAINER */
.checkout-box{
    max-width:900px;
    margin:50px auto;
    background:#fff;
    border-radius:20px;
    padding:40px;
    box-shadow:0 25px 60px rgba(0,0,0,0.12);
}

/* HEADER */
.checkout-title{
    font-size:30px;
    text-align:center;
    color:#14532d;
}
.checkout-sub{
    text-align:center;
    color:#555;
    margin-bottom:35px;
}

/* LABELS */
label{
    font-weight:600;
    margin-bottom:6px;
    display:block;
}

/* INPUTS */
input, textarea{
    width:100%;
    padding:14px;
    border-radius:12px;
    border:1px solid #ddd;
    margin-bottom:18px;
    font-size:15px;
}
input:focus, textarea:focus{
    outline:none;
    border-color:#14532d;
}

/* PAYMENT METHODS */
.payment-methods{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:18px;
    margin-bottom:25px;
}

.method{
    border:2px solid #e5e7eb;
    border-radius:16px;
    padding:20px;
    text-align:center;
    cursor:pointer;
    transition:0.3s;
}
.method img{
    max-height:46px;
    margin-bottom:10px;
}
.method input{
    display:none;
}
.method.active{
    border-color:#fbbf24;
    background:linear-gradient(135deg,#14532d,#fbbf24);
    color:#fff;
}
.method.active img{
    filter:brightness(0) invert(1);
}

/* INFO BOX */
.info-box{
    background:#f9fafb;
    border-left:6px solid #14532d;
    padding:18px;
    border-radius:12px;
    font-size:14px;
    margin-bottom:25px;
}

/* CONDITIONAL */
.manual-fields{
    display:none;
}

/* BUTTON */
button{
    width:100%;
    padding:16px;
    border:none;
    border-radius:14px;
    font-size:16px;
    font-weight:600;
    color:#fff;
    background:linear-gradient(90deg,#14532d,#fbbf24);
    cursor:pointer;
    transition:0.3s;
}
button:hover{
    transform:scale(1.02);
    opacity:0.95;
}
</style>

<script>
function selectMethod(type, el){
    document.querySelectorAll('.method').forEach(m=>{
        m.classList.remove('active');
        m.querySelector('input').checked = false;
    });

    el.classList.add('active');
    el.querySelector('input').checked = true;

    const manual = document.getElementById('manualFields');
    manual.style.display = (type === 'manual') ? 'block' : 'none';

    
    document.getElementById('payment_proof').required = (type === 'manual');
}
</script>
</head>

<body>

<div class="checkout-box">

    <h2 class="checkout-title">Secure Checkout</h2>
    

    <form method="POST" action="payment.php" enctype="multipart/form-data">

        <!-- DELIVERY -->
        <label>Delivery Address</label>
        <textarea name="delivery_address" required placeholder="Full delivery address"></textarea>

        <label>Delivery Date</label>
        <input type="date" name="delivery_date" min="<?= $tomorrow ?>" required>

        <!-- PAYMENT METHODS -->
        <label>Payment Method</label>
        <div class="payment-methods">

            <div class="method" onclick="selectMethod('cash',this)">
                <input type="radio" name="payment_method" value="Cash on Delivery">
                💵 Cash on Delivery
            </div>

            <div class="method" onclick="selectMethod('manual',this)">
                <input type="radio" name="payment_method" value="CBE">
                <img src="assets/images/cbe.png">
                CBE
            </div>

            <div class="method" onclick="selectMethod('manual',this)">
                <input type="radio" name="payment_method" value="Telebirr">
                <img src="assets/images/telebirr.png">
                Telebirr
            </div>

            <div class="method" onclick="selectMethod('manual',this)">
                <input type="radio" name="payment_method" value="Awash">
                <img src="assets/images/awash.png">
                Awash Bank
            </div>

            <div class="method" onclick="selectMethod('manual',this)">
                <input type="radio" name="payment_method" value="Abyssinia">
                <img src="assets/images/abyssinia.png">
                Abyssinia
            </div>

        </div>

        <!-- MANUAL PAYMENT -->
        <div class="manual-fields" id="manualFields">

            <div class="info-box">
                <strong>Payment Instructions</strong><br><br>
                • Pay using the selected method<br>
                • <strong>Merchant Code:</strong> ZENBABA-001<br>
               
                • Upload receipt or screenshot
            </div>


            <label>Upload Payment Proof</label>
            <input type="file" name="payment_proof" id="payment_proof" accept="image/*,application/pdf">

        </div>

        <button type="submit">Confirm & Place Order</button>

    </form>

</div>

</body>
</html>
