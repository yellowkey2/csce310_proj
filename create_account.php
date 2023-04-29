<!-- This file takes care of creating an account for a new user -->
<!-- This file was created by Justin Heger -->

<?php
session_start();
include('./templates/db_login.php');

$_SESSION['usr_name'] = $username;
$username = $_REQUEST['usr_name'];
$password = $_REQUEST['usr_password'];

//check if username already exists and return to login if it does
$sql = "SELECT * FROM users WHERE usr_name = '" . $username . "'";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $account_exists = true;
    header("Location: index.php?accountExists=$account_exists");
}



$sql = "INSERT INTO users (usr_name, usr_passwd) VALUES ('" . $username . "', '" . $password . "')";

if (mysqli_query($conn, $sql)) {
    echo "Records added successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

mysqli_close($conn);
?>