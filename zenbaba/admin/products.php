<?php
session_start();
require_once "../includes/config.php";

/* Admin protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

/* ADD PRODUCT */
if (isset($_POST['add'])) {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $cat   = $_POST['category'];

    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../assets/images/$image");

    $stmt = $conn->prepare("
        INSERT INTO products (name, price, category_id, image)
        VALUES (?,?,?,?)
    ");
    $stmt->bind_param("sdis", $name, $price, $cat, $image);
    $stmt->execute();
}

/* UPDATE PRICE */
if (isset($_POST['update_price'])) {
    $id    = $_POST['product_id'];
    $price = $_POST['new_price'];

    $stmt = $conn->prepare("UPDATE products SET price=? WHERE id=?");
    $stmt->bind_param("di", $price, $id);
    $stmt->execute();
}

/* DELETE PRODUCT */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
}

/* FETCH DATA */
$products = $conn->query("
    SELECT p.*, c.name AS category 
    FROM products p 
    LEFT JOIN categories c ON p.category_id=c.id
");

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Products</title>
<style>
body{font-family:Arial;background:#f4f4f4}
.box{width:95%;margin:30px auto;background:#fff;padding:20px}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border:1px solid #ddd;text-align:center}
th{background:#0a58ca;color:#fff}
input[type=number]{width:80px}
button{padding:5px 10px}
</style>
</head>
<body>

<div class="box">
<h2>📦 Manage Products</h2>

<!-- ADD PRODUCT -->
<form method="post" enctype="multipart/form-data">
    <input name="name" placeholder="Product Name" required>
    <input name="price" type="number" step="0.01" placeholder="Price" required>

    <select name="category" required>
        <option value="">Select Category</option>
        <?php while($c=$categories->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
        <?php endwhile; ?>
    </select>

    <input type="file" name="image" required>
    <button name="add">Add Product</button>
</form>

<hr>

<!-- PRODUCT LIST -->
<table>
<tr>
    <th>Name</th>
    <th>Category</th>
    <th>Price (Edit)</th>
    <th>Image</th>
    <th>Delete</th>
</tr>

<?php while($p=$products->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($p['name']) ?></td>
    <td><?= htmlspecialchars($p['category']) ?></td>

    <!-- EDIT PRICE -->
    <td>
        <form method="post" style="display:flex;gap:5px;justify-content:center">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <input type="number" step="0.01" name="new_price" value="<?= $p['price'] ?>" required>
            <button name="update_price">💾</button>
        </form>
    </td>

    <td>
        <img src="../assets/images/<?= $p['image'] ?>" width="60">
    </td>

    <td>
        <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete product?')">❌</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</div>
</body>
</html>

