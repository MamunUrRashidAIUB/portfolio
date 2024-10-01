<?php
session_start();
$adminLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Initialize an empty array to store blog posts
if (!isset($_SESSION['blog_posts'])) {
    $_SESSION['blog_posts'] = [];
}

// Handle new blog post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $adminLoggedIn) {
    $newPost = htmlspecialchars($_POST['new_blog_post']);
    if (!empty($newPost)) {
        $_SESSION['blog_posts'][] = $newPost; // Store new post in session
    }
}
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
                <a href="#testimonials">Testimonials</a>
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

        <h1>Successful Front-end Development</h1>
        
        <div class="intro">
            <p>Hi, I'm Rashid, a freelance Front-end Developer with 1 year commercial experience creating successful websites.</p>
        </div>

        <div class="services">
            <div class="service">
                <img src="images/25.png" alt="Icon representing front-end development services">
                <h2>Front-end development</h2>
                <p>Responsive websites built for an optimal user experience that achieves your business goals.</p>
            </div>
            <div class="service">
                <img src="images/12.png" alt="Icon representing Flutter app development">
                <h2>Flutter developer</h2>
                <p>Manage apps using the Flutter framework.</p>
            </div>
            <div class="service">
                <img src="images/23.png" alt="Icon representing interface design with Figma">
                <h2>Figma</h2>
                <p>Collaborative web application for interface design, with additional offline features enabled by desktop applications for macOS and Windows.</p>
            </div>
        </div>

        <div class="projects">
            <h2>My Work and Projects</h2>
            <!-- Add project content here -->
        </div>
        
        <div class="projects" id="about">
            <h2>WHO AM I ?</h2>
            <p>Hi I'm Jackson Ford On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country.
            Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
        </div>

        <div class="projects" id="testimonials">
            <h2>EDUCATION</h2>
            <p>Bachelor Degree of Computer Science</p>
            <p>American International University Bangladesh</p>
        </div>

        <div class="projects" id="blog">
            <h2>Blog</h2> 
            <?php if ($adminLoggedIn): ?>
                <div class="blog-posting">
                    <h3>Post a New Blog</h3>
                    <form method="POST" action="">
                        <textarea name="new_blog_post" placeholder="Type your blog post here..." required></textarea>
                        <button type="submit">Post Blog</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if (count($_SESSION['blog_posts']) > 0): ?>
                <?php foreach ($_SESSION['blog_posts'] as $post): ?>
                    <div class="blog-post">
                        <p><?php echo nl2br($post); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No blog posts available.</p>
            <?php endif; ?>
        </div>

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
