<?php
session_start();
require '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];

    // Insert comment
    $sql = "INSERT INTO comments (user_id, post_id, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $post_id, $content);

    if ($stmt->execute()) {
        header("Location: posts.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
