<?php
require_once('../db/DB_connection.php');
require_once('../db/DB_register.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style/register.css">
</head>
<body>
    <div class="container">
        <img style="widht: 100px; margin-bottom: 2rem;" src="../assets/images/logo_app.png" alt="">
        <form method="POST">
            <?php if (isset($error_message)) : ?>
                <div class="error_message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div>
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" placeholer="Username" required>
                </div>
                <div>
                <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholer="*****************" required>
                </div>
                <div>
                    <button type="submit">Register</button>
                </div>
                <p>Have an account? <a href="../index.php">Login</a></p>
        </form>
    </div>
</body>
</html>