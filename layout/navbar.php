<?php 
// session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ./index.php');
    exit;
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard Kasir Pak Kusir</title>
    <link rel="stylesheet" href="../assets/style/dashboard.css">
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
            overflow-x: hidden;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 3.5rem;
            background-color: #343a40;
            color: #fff;
            z-index: 1;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            padding: 10px 20px;
            color: #fff;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .sidebar-header {
            background-color: #212529;
            padding: 20px;
            text-align: center;
        }
        .sidebar-header h3 {
            margin-bottom: 0;
            color: #fff;
        }
        .nav-item {
            margin-bottom: 10px;
        }
        .nav-link {
            color: #fff !important;
            font-weight: bold;
        }
        .nav-link:hover {
            color: #f8f9fa !important;
        }
        .logout-link {
            color: #dc3545 !important;
        }
        .logout-link:hover {
            color: #f8d7da !important;
        }
        .mb-4 {
            background-color: orangered;
            color: #fff;
            padding: 10px;
        }
    </style>
<body>
<div class="sidebar">
        <div class="sidebar-header">
            <h3>Dashboard</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item <?php echo ($role === 'admin') ? '' : 'd-none'; ?>">
                <a class="nav-link" href="../boss/kelola_akun.php">Kelola Akun</a>
            </li>
            <li class="nav-item <?php echo ($role === 'admin' || $role === 'owner') ? '' : 'd-none'; ?>">
                <a class="nav-link" href="../activity/log_activity.php">Log Activity</a>
            </li>
            <li class="nav-item <?php echo ($role === 'admin' || $role === 'kasir') ? '' : 'd-none'; ?>">
                <a class="nav-link" href="../transaksi/index.php">Transaksi</a>
            </li>
            <li class="nav-item <?php echo ($role === 'admin') ? '' : 'd-none'; ?>">
                <a class="nav-link" href="../kasir/manage_product.php">Data Produk</a>
            </li>
        </ul>
        <ul class="nav flex-column mt-auto">
            <li class="nav-item">
                <a class="nav-link logout-link" href="../../db/DB_logout.php">Keluar</a>
            </li>
        </ul>
    </div>
          </body>