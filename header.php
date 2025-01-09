<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session if not already started
}
?>
<header class="header">
    <h1 class="connectsphere">ConnectSphere</h1>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../user/posts.php">Posts</a>
            <a href="../user/profile.php">Profile</a>
            <a href="../messaging/chat.php">Chat</a>
            <a href="../auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>

