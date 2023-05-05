<!-- THIS FILE IS BY SLOAN DAVIS -->
<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, "csce310_db");

// Check connection
if ($conn->connect_error) {
        echo "Could not connect to database";
        die("Connection failed: " . $conn->connect_error);
}
?>