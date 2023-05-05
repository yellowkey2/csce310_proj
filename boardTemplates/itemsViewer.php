<!-- This is a component that will be rendered in the Dashboard to display board items without editing capability -->
<!-- THIS FILE IS BY SLOAN DAVIS -->
<?php
// print_r($_SESSION);
include("templates/db_login.php");
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
$sql = "SELECT * FROM board_item WHERE board_id = " . $board_id;
$items = $conn->query($sql);
while($row = $items->fetch_assoc()){
    echo "<p class='boardItemViewer'> * " . $row['item_content'] . "</p>";
}
?>
<!-- Neccessary for spacing. DO NOT REMOVE -->
<p id="addBoardItem"></p>
