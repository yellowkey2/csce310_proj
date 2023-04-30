<!-- This file takes care of creating an account for a new user -->
<!-- This file was created by Justin Heger -->
<!-- This file was edited by Logan Talton -->

<?php
session_start();
include('./templates/db_login.php');

$username = $_REQUEST['usr_name'];
$password = $_REQUEST['usr_password'];

//check if username already exists and return to login if it does
$sql = "SELECT * FROM users WHERE usr_name = '" . $username . "'";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $account_exists = true;
    header("Location: index.php?accountExists=$account_exists");
    exit();
}

$sql = "INSERT INTO users (usr_name, usr_passwd) VALUES ('" . $username . "', '" . $password . "')";

if (mysqli_query($conn, $sql)) {
    echo '<div style="font-size: 24px; text-align: center; margin-top: 50px;">Records added successfully.</div>';
    echo '<script type="text/javascript">
              window.setTimeout(function(){
                  window.history.back();
              }, 2000);
          </script>';
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

mysqli_close($conn);
?>