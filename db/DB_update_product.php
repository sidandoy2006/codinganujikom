<?php
session_start();
require_once('db_connection.php');

if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $jumlah = $_POST['jumlah']; // tambahan untuk kuantitas

    $stmt = $conn->prepare("UPDATE products SET nama_produk = ?, harga_produk = ?, jumlah = ? WHERE id = ?");
    $stmt->bind_param("siii", $nama_produk, $harga_produk, $jumlah, $id); // menyesuaikan dengan tipe data kuantitas (integer)

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Product updated successfully!";
        } else {
            echo "No changes made to the product.";
        }
    } else {
        echo "Failed to update product.";
    }

    $stmt->close();
    $conn->close();

    header('Location: ../pages/kasir/manage_product.php');
    exit;
}
?>