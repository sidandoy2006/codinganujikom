<?php
session_start();
require_once('../../db/DB_connection.php');

function checkPermission($allowedRoles) {
    // Pastikan session telah dimulai
    if (!isset($_SESSION['loggedin'])) {
        header('location: ../index.php');
        exit;
    }
}

checkPermission(['boss']);

// Periksa apakah data pengguna yang diterima dari formulir telah lengkap
if (isset($_POST['username'], $_POST['password'], $_POST['role'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Lakukan sanitasi input
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Lakukan validasi input jika diperlukan

    // Lakukan query untuk memperbarui informasi akun pengguna di database
    $query = "UPDATE users SET password = '$password', role = '$role' WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika query berhasil dieksekusi, kembalikan pengguna ke halaman dashboard atau halaman lainnya
        header("Location: ../dashboard.php");
        exit();
    } else {
        // Jika terjadi kesalahan saat mengeksekusi query, tampilkan pesan kesalahan
        echo "Failed to update account information.";
    }
} else {
    // Jika data pengguna tidak lengkap, tampilkan pesan kesalahan
    echo "Incomplete user data.";
}
?>