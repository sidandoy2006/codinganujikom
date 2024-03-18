<?php
session_start();
require_once('DB_connection.php');

if (isset($_POST['delete_product']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "product deleted succesfully";
    } else {
        echo "failed to delete product";
    }

    $stmt->close();
    $conn->close();

    header ('Location: ../pages/kasir/manage_product.php');
}
?>