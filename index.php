<?php
require_once('./db/DB_connection.php');
require_once('./db/DB_login.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");

    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        header("Location: pages/dashboard.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Pak Kusir</title>
    <link rel="stylesheet" href="assets/style/login.css">
</head>
<body>

    <div class="container">
        <img style="width: 200px; margin-bottom: 2rem;" src="./assets/images/logo.png" alt="">
        <form method="POST">
            <?php if (isset($error_message)) : ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div>
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Isi Username" required>
            </div>
            <div>
                <label for="pasword">Password</label>
                <input id="password" name="password" type="password" placeholder="Isi Password" required>
            </div>
            <div>
                <button type="submit">Sign in</button>
            </div>
        </form>
    </div>
</body>
</html>