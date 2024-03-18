<?php
session_start();
require_once('../../db/DB_connection.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /index.php');
    exit;
}

// if ($_SESSION["role"] == "kasir") {
//     echo "<script>
//             window.history.back(); 
//           </script>";
//     exit;
//   }


if(isset($_POST['tambah'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $role = $_POST ['role'];

    $add = $conn->prepare("INSERT INTO users (username, password, nama,  role) VALUES (?, ?, ?, ?)");
    $add->bind_param('ssss', $username, $password, $nama, $role);
    $add->execute();

    if($add->affected_rows > 0){
        echo "akun berhasil di tambahkan";
    } else {
        echo "Failed to add product. Error: " . $add->error;
    }

    $add->close();
    $conn->close();
    header('Location:../boss/data_karyawan.php');
    exit;
}

// updat akun
if (isset($_POST['update_product'])){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $updat = $conn->prepare("UPDATE products SET nama = ?, username = ?, password = ?, role = ?, WHERE id= ?");
    $updat->bind_param("ssssi", $nama, $username, $password, $role, $id);
    
    if ($updat->execute()){
        if($updat->affected_rows > 0) {
            echo "akun berhasil di tambahkan";
        }else{
            echo "No changes made to the product";
        }
    }else{
        echo "Failed to update product.";
    }
    $updat->close();
    $conn->close();
    header('location: kelola_akun.php');
    exit();
}

if(isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

}

$query = "SELECT * FROM users";
$result = $conn->query($query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='../../assets/style/data_karyawan.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Data Karyawan</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link " aria-current="page" href="../../dashboard.php">Dashboard</a>
                    <a class="nav-link" href="../kasir/manage_product.php">Manage</a>
                    <a class="nav-link active" href="">Data Karyawan</a>
                </div>
            </div>
            <div>
                <form action="../../db/DB_logout.php" method="post">
                    <button type="submit" class="btn btn-danger">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
    <center>
        <h1 class="dd mt-4"><b>Karyawan</b></h1>
        <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Akun
        </button>
    </center>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo $row["ID"]; ?></td>
            <td><?php echo $row["username"]; ?></td>
            <td><?php echo $row["nama"]; ?></td>
            <td><?php echo $row["role"]; ?></td>
            <td class='action-buttons'>
                <form action='' method='get'>
                    <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                    <button type='button' class='btn btn-warning edit-button' data-bs-toggle='modal' data-bs-target='#update<?php echo $row['id']; ?>' style='width: 120px; margin-top:25px;'>Edit</button>
                </form>
                <form action='../../db/DB_deleteakun.php' method='post'>
                    <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                    <button type='submit' class='btn btn-danger delete-button' name='delete_users' style='width: 120px; margin-top:25px;' onclick="return confirm('apakah kamu yakin ingin menghapus akun ini?')">Delete</button>
                </form>
            </td>
        </tr>

        <!-- Modal Update -->
        <div class="modal fade" id="update<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action=""class="form-container" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <label for="nama">Name:</label>
                        <input type="text" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
                        <br>
                        <label for="password">Password</label>:</label>
                        <input type="text" name="password" value="<?php echo htmlspecialchars($row['password']); ?>" required>
                        <br>
                        <label for="username">Username:</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                        <br>
                        <label for="nama">Role</label>
                        <select name="role" id="role">
                            <option value="boss">Boss</option>
                            <option value="admin">Admin</option>
                            <option value="kasir">kasir</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
                    </form>
                    </div>
                    
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </table>

    <!-- modal tambah -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <?php if(isset($error_message)) : ?>
                        <div class="error_message"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <div>
                            <label for="username">Username*</label>
                            <input type="text" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div>
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" name="nama" placeholder="Your Full Name" required>
                        </div>
                        <div>
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="" required>
                        </div>
                        <div>
                            <label for="nama">Role</label>
                            <select name="role" id="role">
                                <option value="boss">Boss</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">kasir</option>
                            </select>
                        </div>
                    <div>
                        <button type="submit" name="tambah" class="btn btn-primary">Save changes</button>

                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>