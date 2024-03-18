<?php
session_start();
require_once('DB_connection.php');

// Pastikan pengguna terautentikasi sebelum mengakses halaman ini
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /index.php');
    exit;
}

// Memproses permintaan penghapusan akun
if(isset($_POST['delete_users'])){
    $id = $_POST['id'];

    // Query untuk menghapus data akun dari database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data akun berhasil dihapus');
                window.location.href='../pages/boss/data_karyawan.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>