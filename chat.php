<?php
session_start();
require '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Check if receiver exists
    $receiver_check_sql = "SELECT id FROM users WHERE id = ?";
    $receiver_check_stmt = $conn->prepare($receiver_check_sql);
    $receiver_check_stmt->bind_param("i", $receiver_id);
    $receiver_check_stmt->execute();
    $receiver_check_result = $receiver_check_stmt->get_result();

    if ($receiver_check_result->num_rows === 0) {
        echo "Error: Receiver does not exist.";
        exit();
    }

    // Insert message
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);

    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
        exit();
    }

    echo "Message sent successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="chat-container">
        <h2>Chat</h2>
        <form method="POST">
            <select name="receiver_id" required>
                <option value="">Select Recipient</option>
                <?php
                $result = $conn->query("SELECT id, username FROM users");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['username']} (ID: {$row['id']})</option>";
                }
                ?>
            </select>
            <textarea name="message" placeholder="Type your message" required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
