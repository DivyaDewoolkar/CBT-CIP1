<?php
session_start();
require '../includes/db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Handle post creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['content'])) {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    // Insert post into database
    $sql = "INSERT INTO posts (user_id, content, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $content);

    if ($stmt->execute()) {
        header("Location: profile.php"); // Redirect back to profile
        exit;
    } else {
        die("Error: Could not create post.");
    }
}
?>
