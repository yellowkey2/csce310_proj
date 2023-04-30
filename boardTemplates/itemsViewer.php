<!-- This is a component that will be rendered in the Dashboard to display board items without editing capability -->

<?php
session_start();
print_r($_SESSION);
include("templates/db_login.php");
echo "items viewer";
$board_id = "";
//check if got a boardid
if(!$_GET["boardID"]){
    exit;
}
$board_id = $_GET['boardID'];
//check if has permission
if($_SESSION['b_id_' . $board_id] == false){
    echo "no board permission";
    exit;
}
//get and display items
$sql = "SELECT FROM board_item WHERE board_id = " . $board_id;

?>
