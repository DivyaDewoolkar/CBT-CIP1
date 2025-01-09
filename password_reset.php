<?php
require '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Update the user's password
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $email);

    if ($stmt->execute()) {
        $message = "Password has been reset successfully.";
    } else {
        $error = "Error resetting password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Reset</title>
      <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .reset-container {
            background: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .reset-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .reset-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .reset-container input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .reset-container input:focus {
            outline: none;
            border-color: #007bff;
        }

        .reset-container button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .reset-container button:hover {
            background-color: #0056b3;
        }

        .reset-container p {
            font-size: 14px;
            color: #333;
            margin-top: 15px;
        }

        .message-success {
            color: #28a745;
        }

        .message-error {
            color: #dc3545;
        }
    </style>
</head>
<div class="reset-container">
        <h1>Reset Your Password</h1>
        <form action="password_reset.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <button type="submit">Reset Password</button>
        </form>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php elseif (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
