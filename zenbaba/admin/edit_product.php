<?php
require_once "../includes/config.php";

/* 1️⃣ Get product ID */
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

/* 2️⃣ Fetch product */
$product_query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($product_query);

if (!$product) {
    echo "Product not found";
    exit;
}

/* 3️⃣ Fetch categories */
$categories = mysqli_query($conn, "SELECT * FROM categories");

/* 4️⃣ Update product */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float)$_POST['price'];
    $category = (int)$_POST['category'];

    // Image update (optional)
    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../assets/images/$image");

        mysqli_query($conn, "
            UPDATE products 
            SET name='$name', price='$price', image='$image', category_id='$category'
            WHERE id=$id
        ");
    } else {
        mysqli_query($conn, "
            UPDATE products 
            SET name='$name', price='$price', category_id='$category'
            WHERE id=$id
        ");
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, select, button { width: 300px; padding: 8px; margin: 6px 0; }
        img { width: 120px; display: block; margin-bottom: 10px; }
        button { background: #007bff; color: white; border: none; }
    </style>
</head>
<body>

<h2>Edit Product</h2>

<form method="POST" enctype="multipart/form-data">

    <label>Product Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

    <label>Price (USD)</label>
    <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

    <label>Category</label>
    <select name="category" required>
        <?php while ($c = mysqli_fetch_assoc($categories)): ?>
            <option value="<?php echo $c['id']; ?>"
                <?php if ($c['id'] == $product['category_id']) echo "selected"; ?>>
                <?php echo $c['name']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Current Image</label>
    <img src="../assets/images/<?php echo $product['image']; ?>">

    <label>Change Image (optional)</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Update Product</button>
</form>

<br>
<a href="index.php">⬅ Back to Products</a>

</body>
</html>
