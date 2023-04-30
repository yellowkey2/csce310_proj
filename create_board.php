<?php
include("templates/db_login.php");
$board_admin_id = $_REQUEST['usr_id'];
$board_name = $_REQUEST['board_name'];
$admin_access_level = 0;

//add board to boards table
$sql = "INSERT INTO board (board_name, board_admin_id) VALUES ('" . $board_name . "', '" . $board_admin_id . "')";
$result = $conn->query($sql);

//get the new board id
$board_id = $conn->insert_id;

//add the admin to the board assigmnents table
$sql = "INSERT INTO board_assignments (usr_id, board_id, access_level) VALUES ('". $board_admin_id . "', " . $board_id . ", " . $admin_access_level . ")"; 
$result = $conn->query($sql);

// Check if board was created
$sql = "SELECT * FROM board WHERE board_name = '" . $board_name . "' AND board_admin_id = '" . $board_admin_id . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "Board was not created";
} else {
    echo "Board created successfully";
    // Redirect to dashboard page
    header("Location: dashboard.php");
}
$conn->close();
?>
