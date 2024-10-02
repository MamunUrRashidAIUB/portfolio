<?php
require 'connection/db_connect.php';
session_start();
$adminLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Initialize an empty array to store blog posts
if (!isset($_SESSION['blog_posts'])) {
    $_SESSION['blog_posts'] = [];
}

// Handle new blog post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $adminLoggedIn) {
    $newTitle = htmlspecialchars($_POST['new_blog_title']);
    $newPost = htmlspecialchars($_POST['new_blog_post']);
    if (!empty($newPost) && !empty($newTitle)) {
        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO blogs (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $newTitle, $newPost);
        $stmt->execute();
        $stmt->close();
    }
}
// Fetch blog posts
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rashid - Front-end Developer</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">Rashid</div>
            <button class="menu-toggle" aria-label="Open navigation menu">☰</button>
            <nav class="nav-menu">
                <a href="#home">Home</a>
                <a href="#portfolio">Portfolio</a>
                <a href="#about">About</a>
                <a href="#testimonials">Education</a>
                <a href="#blog">Blog</a>
                <a href="#contact" class="cta-button">Get in Touch</a>
                <!-- Conditional Login/Logout button -->
                <?php if ($adminLoggedIn): ?>
                    <a href="loginandlogout/logout.php" class="login-button">Logout</a>
                <?php else: ?>
                    <a href="loginandlogout/login.php" class="login-button">Login</a>
                <?php endif; ?>
            </nav>
        </header>
        <div class="who-am-i-section" id="about">
    <div class="who-am-i-container">
      
        <div class="who-am-i-image">
            <img src="images/55.jpeg" alt="Image of Rashid">
        </div>
        <div class="who-am-i-text">
            
            <p>Hi, I'm Rashid. On her way, she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. Even the all-powerful Pointing has no control over the blind texts; it is an almost unorthographic life. One day, however, a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
        </div>
    </div>
</div>
        <div class="projects" id="testimonials">
            <h2>EDUCATION </h2>
            <p>Bachelor Degree of Computer Science</p>
            <p>American International University Bangladesh</p>
        </div>
<!-- blog section -->
<div class="projects" id="blog">
            <h2>Blog</h2> 
            <?php if ($adminLoggedIn): ?>
                <div class="blog-posting">
                    <h3>Post a New Blog</h3>
                    <form method="POST" action="">
                        <input type="text" name="new_blog_title" placeholder="Blog Title" required><br><br>
                        <textarea name="new_blog_post" placeholder="Type your blog post here..." required></textarea>
                        <button type="submit">Post Blog</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="blog-post">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                        <small>Posted on: <?php echo $row['created_at']; ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No blog posts available.</p>
            <?php endif; ?>
        </div>
<!-- blog section end -->
        <div class="contact-form" id="contact-form">
            <h3>Enter your email address</h3>
            <input type="email" id="email" placeholder="Your email" required>
            
            <h3>Your Message</h3>
            <textarea id="message" placeholder="Type your message here..." required></textarea>
            
            <button id="send-button">Send</button>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
