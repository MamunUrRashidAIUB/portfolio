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
    $newTitle = isset($_POST['new_blog_title']) ? htmlspecialchars($_POST['new_blog_title']) : '';
    $newPost = isset($_POST['new_blog_post']) ? htmlspecialchars($_POST['new_blog_post']) : '';

    if (!empty($newPost) && !empty($newTitle)) {
        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO blogs (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $newTitle, $newPost);
        $stmt->execute();
        $stmt->close();
    }
}
// Handle delete project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_project_id']) && $adminLoggedIn) {
    $deleteProjectId = intval($_POST['delete_project_id']);

    // Prepare and execute the DELETE SQL statement
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $deleteProjectId);
    $stmt->execute();
    $stmt->close();

    // Optional: Redirect to avoid form resubmission on refresh
    header("Location: index.php");
    exit;
}


// Fetch blog posts
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = $conn->query($sql);
// Handle delete blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post_id']) && $adminLoggedIn) {
    $deletePostId = intval($_POST['delete_post_id']);

    // Prepare and execute the DELETE SQL statement
    $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $deletePostId);
    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rashid - Front-end Developer</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&family=Kalnia+Glaze:wght@100..700&family=Nabla&display=swap" rel="stylesheet">
</head>

<body id="home">
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

                    <p>
                    <h1>Hi, I'm Mamun Ur Rashid</h1>i'm currently pursuing my degree in Computer Science and Engineering
                    (CSE) at
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
                <p>Bangladesh Navy College, Chattogram</p>
            </div>
            <div class="education-item">
                <p><strong>2016-2018</strong></p>
                <p>Science</p>
                <p>Nasirabad Govt. High School, Chattogram</p>
            </div>
        </div>
        
      <!-- Education Section ends here -->

<!-- Projects Section -->
<!-- Projects Section -->
<section id="projects" class="projects-section">
    <h2>My Projects</h2>
    <div class="projects-container">
        <?php
        require 'connection/db_connect.php';
        
        $query = "SELECT * FROM projects ORDER BY created_at DESC";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="project-item">
                <?php if (!empty($row['image'])) { ?>
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                <?php } ?>
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['description']; ?></p>

                <?php if ($adminLoggedIn): ?>
                    <!-- Delete Button -->
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="delete_project_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php
        }
        ?>
    </div>
</section>

<?php
if (isset($_SESSION['admin_logged_in'])) { // Only show the form if admin is logged in
?>
    <div class="project-posting">
        <h3>Add New Project</h3>
        <form action="add_project.php" method="POST" enctype="multipart/form-data">
            <label for="title">Project Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Project Description:</label>
            <textarea name="description" id="description" required></textarea>

            <label for="image">Project Image:</label>
            <input type="file" name="image" id="image">

            <button type="submit">Add Project</button>
        </form>
    </div>
<?php
}
?>


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

                        <?php if ($adminLoggedIn): ?>
                            <!-- Delete Button -->
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="delete_post_id" value="<?php echo $row['id']; ?>">
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No blog posts available.</p>
            <?php endif; ?>

        </div>
        <!-- blog section end -->
        <!-- Replace this section -->
        <div class="footer" id="contact">
            <div class="footer-container">
                <div class="footer-text">
                    <h3>Let’s Talk</h3>
                    <p>Every project starts with a chat. I will be happy to discuss your project.</p>
                </div>
                <div class="footer-contact">
                    <p>Email: <a href="mailto:md.mamun.ur.rashid.cse@gmail.com">md.mamun.ur.rashid.cse@gmail.com</a></p>
                    <p class="phone">Phone:
                        01880299555,
                        01729402303</p>
                    <p>Address: Bashundhara, Block C, Road 8, Dhaka</p>
                </div>
                <div class="footer-social">
                    <a href="https://www.facebook.com/profile.php?id=100026601601848" target="_blank"><img
                            src="images/icons8-facebook-48.png" alt="Facebook"></a>
                    <a href="https://www.linkedin.com/in/md-mamun-ur-rashid-7a95ab251" target="_blank"><img
                            src="images/icons8-linkedin-48.png" alt="LinkedIn"></a>
                    <a href="https://www.youtube.com/@MD.MamunUrRashid-vy2ej" target="_blank"><img
                            src="images/icons8-youtube-48.png" alt="YouTube"></a>
                    <a href="https://wa.me/+8801880299555" target="_blank"><img src="images/icons8-whatsapp-48.png"
                            alt="WhatsApp"></a>
                    <a href="https://github.com/MamunUrRashidAIUB" target="_blank"><img
                            src="images/icons8-github-48.png" alt="Instagram"></a>
                </div>
            </div>
        </div>

    </div>

    <script src="js/script.js"></script>
</body>

</html>