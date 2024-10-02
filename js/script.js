document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    menuToggle.addEventListener('click', function () {
        navMenu.classList.toggle('active');
    });

    document.querySelector('.cta-button').addEventListener('click', function () {
        const contactForm = document.getElementById('contact-form');
        contactForm.scrollIntoView({ behavior: 'smooth' });
    });

    document.getElementById('send-button').addEventListener('click', function () {
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        if (email && message) {
            console.log('Email:', email);
            console.log('Message:', message);
            // Here you can add functionality to send the email and message
            alert('Your message has been sent!'); // Placeholder alert
            document.getElementById('email').value = ''; // Clear the input fields
            document.getElementById('message').value = '';
        } else {
            alert('Please fill in both fields.');
        }
    });
});
