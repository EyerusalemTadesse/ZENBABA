<?php
require_once "../includes/config.php";

$categories = mysqli_query($conn, "SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float)$_POST['price'];
    $category = (int)$_POST['category'];

    if (!empty($_FILES['image']['name'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../assets/images/$image");
    } else {
        $image = "";
    }

    $sql = "
        INSERT INTO products (name, price, image, category_id)
        VALUES ('$name', '$price', '$image', '$category')
    ";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input, select, button { width: 300px; padding: 8px; margin: 6px 0; }
        button { background: #28a745; color: white; border: none; }
    </style>
</head>
<body>

<h2>Add New Product</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required>

    <input type="number" step="0.01" name="price" placeholder="Price (USD)" required>

    <select name="category" required>
        <option value="">-- Select Category --</option>
        <?php while ($c = mysqli_fetch_assoc($categories)): ?>
            <option value="<?php echo $c['id']; ?>">
                <?php echo $c['name']; ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="file" name="image" accept="image/*" required>

    <button type="submit">Add Product</button>
</form>

<br>
<a href="index.php">⬅ Back to Products</a>

</body>
</html>

