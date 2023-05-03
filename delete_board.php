<?php
include("./templates/db_login.php");

$board_admin_id = $_REQUEST['usr_id'];
$board_id = $_REQUEST['board_id'];

//delete row from board assignments, board_items, appointments and appointment_assignments
$sql = "DELETE FROM board_assignments WHERE board_id = '" . $board_id . "'";
$result = $conn->query($sql);
//delete row from board_items
$sql = "DELETE FROM board_item WHERE board_id = '" . $board_id . "'";
$result = $conn->query($sql);
//get apointment id from appointments
$sql = "SELECT appt_id FROM appointment WHERE board_id = " . $board_id;
$appointment_ids = $conn->query($sql);
while ($appointment_id = $appointment_ids->fetch_assoc()) {
    $appointment_id = $appointment_id["appt_id"];

    //delete row from appointment_assignments where appointment id = 
    $sql = "DELETE FROM appointment_assignments WHERE appointment_id = '" . $appointment_id . "'";
    $result = $conn->query($sql);
    //delete row from appointments
    $sql = "DELETE FROM appointment WHERE appt_id = '" . $appointment_id . "'";
    $result = $conn->query($sql);
}
//delete row from board
$sql = "DELETE FROM board WHERE board_id = '" . $board_id . "'";
$result = $conn->query($sql);
// Check if board was deleted
$sql = "SELECT * FROM board WHERE board_id = '" . $board_id . "' AND board_admin_id = '" . $board_admin_id . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {

    echo "Board deleted successfully";
    // Redirect to dashboard page
    header("Location: dashboard.php");
} else {
    echo "Board was not deleted";
}
