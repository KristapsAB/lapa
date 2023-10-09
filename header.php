<!DOCTYPE html>
<html>
<head>
    <title>Your Web App</title>
    <link rel="stylesheet" type="text/css" href="header.css">
</head>
<body>
    <header>
        <nav>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <p>Welcome, <?php echo $_SESSION['username']; ?>
                </ul>
            <?php else : ?>
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>
