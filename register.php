<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];


    $hashed_password = password_hash($entered_password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "task_management";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_username_sql = "SELECT id FROM users WHERE username = ?";
    $check_username_stmt = $conn->prepare($check_username_sql);
    $check_username_stmt->bind_param("s", $entered_username);
    $check_username_stmt->execute();
    $check_username_stmt->store_result();

    if ($check_username_stmt->num_rows > 0) {
        echo "Username already taken.";
    } else {
        $insert_user_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $insert_user_stmt = $conn->prepare($insert_user_sql);
        $insert_user_stmt->bind_param("ss", $entered_username, $hashed_password);

        if ($insert_user_stmt->execute()) {
            echo "Registration successful! You can now log in.";
        } else {
            echo "Registration failed.";
        }
    }

    $check_username_stmt->close();
    $insert_user_stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <?php
                if (isset($error_message)) {
                    echo '<div class="error-message">' . $error_message . '</div>';
                }
                ?>
                <form class="login" action="register.php" method="POST">
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" class="login__input" name="username" placeholder="User name" required>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" class="login__input" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="button login__submit">
                        <span class="button__text">Register</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>
                <div class="social-login">
                    <h3>or log in via</h3>
                    <div class="social-icons">
                        <a href="#" class="social-login__icon fab fa-instagram"></a>
                        <a href="#" class="social-login__icon fab fa-facebook"></a>
                        <a href="#" class="social-login__icon fab fa-twitter"></a>
                        <button type="button" class="button login__toggle" id="loginToggle">
    <span class="button__text">Login</span>
    <i class="button__icon fas fa-chevron-right"></i>
</button>

                        </button>
                    </div>
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>        
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>      
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

