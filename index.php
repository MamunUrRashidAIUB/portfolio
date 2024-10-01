<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rashid - Front-end Developer</title>
    <link rel="stylesheet" href="style.css">
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
            <h2>About Me</h2>
            <p>Your about section content goes here.</p>
        </div>

        <div class="projects" id="testimonials">
            <h2>Testimonials</h2>
            <p>Your testimonials section content goes here.</p>
        </div>

        <div class="projects" id="blog">
            <h2>Blog</h2>
            <p>Your blog section content goes here.</p>
        </div>

        <div class="contact-form" id="contact-form">
    <h3>Enter your email address</h3>
    <input type="email" id="email" placeholder="Your email" required>
    
    <h3>Your Message</h3>
    <textarea id="message" placeholder="Type your message here..." required></textarea>
    
    <button id="send-button">Send</button>
</div>


    </div>

    <script src="script.js"></script>
</body>
</html>
