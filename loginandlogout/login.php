<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace with your actual login credentials
    $adminUsername = 'admin';
    $adminPassword = '123'; // Ensure to use hashing for secure login in real-world scenarios.

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $adminUsername && $password === $adminPassword) {
        // Store login information in session
        $_SESSION['admin_logged_in'] = true;
        header('Location: ../index.php');
        exit();
    } else {
        echo "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
