<!-- This is a component that will be rendered in the Dashboard to display board items without editing capability -->

<?php
session_start();
print_r($_SESSION);
include("templates/db_login.php");
echo "items viewer";
?>
