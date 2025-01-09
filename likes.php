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

    // Check if user already liked the post
    $check_sql = "SELECT * FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Add like
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $post_id);
        $stmt->execute();
    }

    header("Location: posts.php");
}
?>
