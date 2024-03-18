<?php
// Lakukan pengecekan apakah metode yang digunakan adalah GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ambil rentang tanggal dari URL
    $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

    // Validasi rentang tanggal
    if (!empty($start_date) && !empty($end_date)) {
        // Koneksi ke database
        include '../../db/db_connection.php';

        // Ambil rentang tanggal dari URL
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

        // Variabel untuk urutan pengurutan
        $sort_order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

        // Validasi rentang tanggal
        if (!empty($start_date) && !empty($end_date)) {
            // Koneksi ke database
            include '../../db/db_connection.php';

            // Konversi format tanggal ke format MySQL
            $start_date = date('Y-m-d', strtotime($start_date));
            $end_date = date('Y-m-d', strtotime($end_date));

            // Query untuk mengambil data transaksi dengan sorting berdasarkan tanggal transaksi
            $query = "SELECT 
                        transaksi.id, 
                        transaksi.tanggal_pembuatan, 
                        transaksi.username, 
                        GROUP_CONCAT(transaksi_produk.nama_produk) AS nama_barang, 
                        transaksi.total_harga, 
                        transaksi.uang_pelanggan, 
                        transaksi.kembalian 
                      FROM 
                        transaksi 
                      JOIN 
                        transaksi_produk ON transaksi.id = transaksi_produk.id_transaksi
                      WHERE 
                        DATE(transaksi.tanggal_pembuatan) BETWEEN ? AND ?
                      GROUP BY 
                        transaksi.id
                      ORDER BY 
                        transaksi.tanggal_pembuatan $sort_order
                      LIMIT 0, 25";

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                die("Error: " . mysqli_error($conn));
            }
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Cetak Log Aktivitas</title>
                <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/logo.png">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    /* Gaya dari navbar */
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
                    .content {
                        padding: 20px;
                    }
                    .logout-link {
                        color: #dc3545 !important;
                    }
                    .logout-link:hover {
                        color: #f8d7da !important;
                    }
                </style>
            </head>
            <body>
                <div class="container-fluid">
                    <div class="content">
                        <h2 class="mt-5">Log Aktivitas Transaksi</h2>
                        <div class="text-end mb-3">
                            <a href="../activity/log_activity.php" class="btn btn-primary">Kembali ke Log Activity</a>
                            <button onclick="window.print()" class="btn btn-success">Cetak</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal Transaksi</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">Uang Pelanggan</th>
                                    <th scope="col">Kembalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) : ?>
                                        <tr>
                                            <td><?php echo $row['tanggal_pembuatan']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['nama_barang']; ?></td>
                                            <td>Rp. <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                            <td>Rp. <?php echo number_format($row['uang_pelanggan'], 0, ',', '.'); ?></td>
                                            <td>Rp. <?php echo number_format($row['kembalian'], 0, ',', '.'); ?></td>
                                        </tr>
                                <?php 
                                    endwhile; 
                                } else {
                                    echo "Tidak ada data yang ditemukan.";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </body>
            </html>
            <?php
            // Tutup koneksi database
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            echo "Rentang tanggal tidak valid.";
        }
    } else {
        echo "Rentang tanggal tidak valid.";
    }
} else {
    echo "Metode yang digunakan tidak valid.";
}
?>
