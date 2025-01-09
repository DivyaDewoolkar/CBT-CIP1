<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConnectSphere</title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <!-- Include Header -->
    <?php include 'includes/header.php'; ?>
    
    <main>
        <section class="welcome">
            <h2>Welcome to ConnectSphere</h2><br>   
            <p>Join our community and connect with your friends!</p>
            <p><a class="btn" href="auth/register.php">Get Started</a></p>
        </section>
    </main>

    <!-- Include Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
