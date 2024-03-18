<?php
session_start();
require_once ('DB_connection.php');

function attempt_login($username, $password, $role) {
    global $conn;

}

if ($_SERVER["REQUEST_METHOD"]== "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
    
        header("Location: pages/dashboard.php");
    } else {
        echo "Invalid username or password";
    }
}
?> 
