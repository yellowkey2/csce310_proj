<!-- This is a component that will be rendered in the Dashboard to display board appointments without editing capability -->

<?php
// session_start();
include("templates/db_login.php");

//check if got a boardid
if (!$_GET["boardID"]) {
    exit;
}
$board_id = $_GET['boardID'];
//check if has permission
if ($_SESSION['b_id_' . $board_id] == false) {
    echo "no board permission";
    exit;
}
//get and display items
$sql = "SELECT * FROM appointment WHERE board_id = '" . $board_id . "'";
$items = $conn->query($sql);
while ($row = $items->fetch_assoc()) {
    echo "<h6>appointment type:<b>" . $row['appt_type'] . "</b></h6>";
    echo "<h6>appointment type:<b>" . $row['appt_name'] . "</b></h6>";
}
?>