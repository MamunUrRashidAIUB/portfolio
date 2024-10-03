<?php

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect to login if not logged in
    header('Location: login.php');
    exit();
}

require 'connection/db_connect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    } else {
        $image = null;
    }

    $sql = "INSERT INTO projects (title, description, image) VALUES ('$title', '$description', '$image')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Project added successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>