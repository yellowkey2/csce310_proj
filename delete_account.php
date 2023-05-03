<?php
session_start();
if (!isset($_SESSION['usr_id'])) {
    echo "no account found to delete";
    exit;
}
include("./templates/db_login.php");
$usr_id = $_SESSION['usr_id'];
//boards that have usr_id: appointment_assignments, board, board_assignments, board_item, users

//delete from appointment_assignments
$sql = "DELETE FROM appointment_assignments WHERE usr_id = $usr_id";
$conn->query($sql);

//delete board assignments
$sql = "DELETE FROM board_assignments WHERE usr_id = $usr_id";
$conn->query($sql);

//delete board item 
$sql = "DELETE FROM board_item WHERE usr_id = $usr_id";
$conn->query($sql);

//delete boards
$sql = "SELECT board_id FROM board WHERE board_admin_id = $usr_id";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $_REQUEST['usr_id'] = $usr_id;
    $_REQUEST['board_id'] = $row['board_id'];
    include_once("./delete_board.php");
}
$sql = "DELETE FROM board WHERE board_admin_id = $usr_id";
$conn->query($sql);

//delete from users
$sql = "DELETE FROM users WHERE usr_id = $usr_id";
$conn->query($sql);
header("Location: index.php");
$conn->close();

