<?php
session_start();
require '../includes/db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php"); // Fixed relative path
    exit;
}

// Fetch logged-in user's details
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch user's posts
$sql_posts = "SELECT id, content, created_at FROM posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bind_param("i", $user_id);
$stmt_posts->execute();
$posts = $stmt_posts->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="profile-container">
        <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
        
        <!-- Post Creation Form -->
        <form method="POST" action="posts_handler.php">
            <textarea name="content" placeholder="What's on your mind?" rows="5" required></textarea>
            <button type="submit">Post</button>
        </form>

        <h3>Your Posts</h3>
        <div class="posts">
            <?php if ($posts->num_rows > 0): ?>
                <?php while ($post = $posts->fetch_assoc()): ?>
                    <div class="post-card">
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <p class="timestamp"><?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You haven't posted anything yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
