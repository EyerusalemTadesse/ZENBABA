<?php
require_once __DIR__ . "/config.php";

$cats = mysqli_query($conn, "
    SELECT * FROM categories 
    WHERE parent_id IS NULL
");
?>

<div class="sidebar">

    <h3>Categories</h3>

    <ul>
        <?php while ($c = mysqli_fetch_assoc($cats)) { ?>
            <li>
                <a href="index.php?cat=<?php echo $c['id']; ?>">
                    <?php echo htmlspecialchars($c['name']); ?>
                </a>
            </li>
        <?php } ?>
    </ul>

    <div style="margin-top:20px; text-align:center; font-size:14px;">
        <strong>
            Prices in <?php echo $_SESSION['currency'] === 'USD' ? 'USD' : 'ETB'; ?>
        </strong>
    </div>

</div>


