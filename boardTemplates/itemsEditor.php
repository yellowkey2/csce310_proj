<!-- This is a component that will be rendered in the Dashboard to display board items with editing capability -->

<?php
// print_r($_SESSION);
include("templates/db_login.php");
echo "items editor";
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
$sql = "SELECT * FROM board_item WHERE board_id = '" . $board_id . "'";
$items = $conn->query($sql);
while($row = $items->fetch_assoc()){
    echo "<br>" . $row['item_content'];
}
?>