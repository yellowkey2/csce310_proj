<?php
include("templates/db_login.php");
$board_admin_id = $_REQUEST['usr_id'];
$board_name = $_REQUEST['board_name'];

$sql = "INSERT INTO board (board_name, board_admin_id) VALUES ('" . $board_name . "', '" . $board_admin_id . "')";
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
mysqli_close($conn);
?>
