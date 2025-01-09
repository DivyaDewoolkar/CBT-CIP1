<?php
session_start();
require '../includes/db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Create a post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    $image = null;

    // File upload handling
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = "uploads/" . basename($_FILES['image']['name']);
        }
    }

    $sql = "INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $content, $image);

    if ($stmt->execute()) {
        header("Location: posts.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch all posts
$sql = "SELECT posts.id, posts.content, posts.image, posts.created_at, users.username 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Posts</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<center>
    <div class="container">
        <h2>What's on your mind?</h2>
        <form action="posts.php" method="POST" enctype="multipart/form-data" class="post-form">
            <textarea name="content" placeholder="Share your thoughts..." required></textarea>
            <input type="file" name="image">
            <button type="submit">Post</button>
        </form>
        <hr>
        <div class="posts-section">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="post-card">
                        <p><strong><?php echo $row['username']; ?></strong></p>
                        <p><?php echo $row['content']; ?></p>
                        <?php if ($row['image']): ?>
                            <img src="../<?php echo $row['image']; ?>" alt="Post Image">
                        <?php endif; ?>
                        <p class="timestamp"><?php echo $row['created_at']; ?></p>
                        <div class="actions">
                            <form action="likes.php" method="POST">
                                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Like</button>
                            </form>
                            <form action="comments.php" method="POST">
                                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="content" placeholder="Add a comment">
                                <button type="submit">Comment</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No posts yet.</p>
            <?php endif; ?>
        </div>
    </div>
    </center>
</body>
</html>
