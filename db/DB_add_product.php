<?php
session_start();
require_once('DB_connection.php');

if (isset($_POST['add_product'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga_produk = $_POST['harga_produk'];
    $jumlah = $_POST['jumlah'];
    
    $kode_unik = uniqid();

    $stmt = $conn->prepare("INSERT INTO products (nama_produk, harga_produk, jumlah, kode_unik) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $nama_produk, $harga_produk, $jumlah, $kode_unik);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "product added seccessfully";
    } else {
        echo "failed to add product. Error: ". $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header('Location: ../pages/kasir/manage_product.php');
    exit;
}
?>