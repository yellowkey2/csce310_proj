<?php
$conn = mysqli_connect("localhost", "root", "", "csce310_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else
    echo "Connected successfully <br>";
$board_admin_id = $_REQUEST['usr_id'];
$board_name = $_REQUEST['board_name'];

$sql = "DELETE FROM board WHERE board_name = '" . $board_name . "' AND board_admin_id = '" . $board_admin_id . "'";
$result = $conn->query($sql);
// Check if board was deleted
$sql = "SELECT * FROM board WHERE board_name = '" . $board_name . "' AND board_admin_id = '" . $board_admin_id . "'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {

    echo "Board deleted successfully";
    // Redirect to dashboard page
    header("Location: dashboard.php");
} else {
    echo "Board was not deleted";
}
mysqli_close($conn);
?>
