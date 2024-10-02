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

                    <p>I am Mamun Ur Rashid, currently pursuing my degree in Computer Science and Engineering (CSE) at
                        American International University, where I’m in my 9th semester. I have a deep passion for
                        technology and always strive to learn and explore new concepts within CSE. My interests span a
                        wide range, from app and website design, where I utilize Figma for creative interfaces, to
                        backend development using programming languages like PHP, CSS, HTML, JavaScript, C++, and C#. I
                        have developed several personal and academic projects, including designing Windows Forms
                        applications as part of my university coursework.My proficiency extends to working with
                        databases, particularly using phpMyAdmin and MySQL, where I have gained a solid understanding of
                        how to manage and maintain databases effectively. During my breaks from formal education, I
                        dedicate time to learning new programming languages and honing my existing skills to stay ahead
                        in the fast-evolving field of technology. Whether it’s web development, software design, or
                        working on complex coding challenges, I’m always eager to dive deeper into these subjects,
                        continuously aiming to expand my expertise and deliver high-quality solutions in every project I
                        undertake.</p>
                </div>
            </div>
        </div>
        <!-- <div class="projects" id="testimonials">
            <h2>EDUCATION </h2>
            <p>Bachelor Degree of Computer Science</p>
            <p>American International University Bangladesh</p>
        </div> -->
        <div class="education-section" id="testimonials">
            <h2>Education</h2>
            <div class="education-item">
                <p><strong>2022-2025</strong></p>
                <p>Bachelor Degree of Computer Science</p>
                <p>American International University Bangladesh</p>
            </div>
            <div class="education-item">
                <p><strong>2018-2020</strong></p>
                <p>Science</p>
                <p>Bangladesh Navy College</p>
            </div>
            <div class="education-item">
                <p><strong>2016-2018</strong></p>
                <p>Science</p>
                <p>Nasirabad Govt. High School, Chattogram</p>
            </div>
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