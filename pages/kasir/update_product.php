<?php
session_start();
require_once('../../db/DB_connection.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php'); 
    exit;
}

if(isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if(!$product) {
        exit('Product not found.');
    }
} else {
    exit('Product ID not specified.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../assets/style/update_product.css">
    <link rel="stylesheet" href="../../assets/style/navbar.css">
</head>
<body>
    <h1>Edit Product</h1>
    <div class="form-container">
        <form action="../../db/DB_update_product.php" method="post">
            <input type="hidden" name="id" value="<?php echo isset($product['id']) ? $product['id'] : ''; ?>">
            <label for="nama_produk">Product Name:</label>
            <input type="text" name="nama_produk" value="<?php echo isset($product['nama_produk']) ? htmlspecialchars($product['nama_produk']) : ''; ?>" required>
            <br>
            <label for="harga_produk">Product Price:</label>
            <input type="number" name="harga_produk" value="<?php echo isset($product['harga_produk']) ? htmlspecialchars($product['harga_produk']) : ''; ?>" required>
            <br>
            <label for="jumlah">Quantity:</label>
            <input type="number" name="jumlah" value="<?php echo isset($product['jumlah']) ? htmlspecialchars($product['jumlah']) : ''; ?>" required>
            <br>
            <button type="submit" name="update_product">Update Product</button>
        </form>
    </div>
</body>
</html>