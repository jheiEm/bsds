<?php
// db.php - Database Connection
$host = 'localhost'; // Your host
$username = 'root'; // Your database username
$password = ''; // Your database password
$dbname = 'bsds'; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
