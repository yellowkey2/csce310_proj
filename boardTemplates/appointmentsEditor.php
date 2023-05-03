<!-- This is a component that will be rendered in the Dashboard to display board appointments with editing capability -->

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
    echo "<form method='POST' class='appointmentEditor'>";
    echo $row['appt_name'];
    echo "<button type='submit' name='delete'>Delete</button>";
    echo "<button type='submit' name='update'>Update</button>";
    echo "</form>";
}
?>
<div id="addAppointment">
    <h3>Add Item:</h3>
     <form method="POST">
        <input type="text" name="apptContent" placeholder='Describe Appointment'>
        <button type="submit" name="addItemBtn">Submit</button>
     </form>
</div>