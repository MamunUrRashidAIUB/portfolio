<?php
$servername = "sql101.infinityfree.com"; // or your server name
$username = "if0_37435221";
$password = "Rashid2285";
$dbname = "myportfolio"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
