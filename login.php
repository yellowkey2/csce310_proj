<!-- This file acts as the login option for the login page. It will redirect the user to their dashboard if their credentials match the database -->
<!-- This file was created by Justin Heger -->

<?php
session_start();
include("./templates/db_login.php");

$username = $_REQUEST['usr_name'];
$password = $_REQUEST['usr_password'];

$_SESSION['usr_name'] = $username;

// Check if username is already in the database
$sql = "SELECT * FROM users WHERE usr_name = '" . $username . "' AND usr_passwd = '" . $password . "'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Redirect to login page
    header("Location: index.php?passwordIncorrect=true");
} else {
    // Redirect to dashboard page
    header("Location: dashboard.php");
}

mysqli_close($conn);
?>