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

//handle queries for add appt
//TODO

//handle queries for update and delete
$appt_id = "";
if (isset($_POST['apptID'])) {
    $appt_id = $_POST['apptID'];
}
//delete appt
if (isset($_POST['delete'])) {
    //delete from appt
    $sql = "DELETE FROM appointment_assignments WHERE appointment_id = $appt_id";
    $conn->query($sql);
    //delete actual appointment
    $sql = "DELETE FROM appointment WHERE appt_id = $appt_id AND board_id = $board_id";
    $conn->query($sql);
}

//TODO
//update appt
if (isset($_POST['update']) && isset($_POST['newUsr'])) {
    //check if user is in board
    $sql = "SELECT usr_id FROM board_assignments WHERE usr_id = " . $_POST['newUsr'] . "AND board_id = $board_id";
    $result = $conn->query($sql);
    if($result->num_rows != 0){
        //add appointment assignment to user
        $sql = "INSERT INTO appointment_assignments (usr_id, appointment_id) VALUES (" . $_POST['newUsr'] . ", $appt_id)";
        $conn->query($sql);
    }
    
}
?>
<div class="vertScroll">
    <?php
    //get and display items
    $sql = "SELECT * FROM appointment WHERE board_id = '" . $board_id . "'";
    $items = $conn->query($sql);
    while ($row = $items->fetch_assoc()) {
        echo "<form method='POST' class='appointmentEditor'>";
        echo $row['appt_name'];
        echo "<input type='hidden' name='apptID' value='" . $row["appt_id"] . "'>";
        echo "<input type='text' name='newUsr' placeholder='user id'>";
        echo "<button type='submit' name='update'>Add Attendee</button>";
        echo "<button type='submit' name='delete'>Delete</button>";
        echo "</form>";
    }
    ?>
</div>
<div id="addAppointment">
    <h3>Add Appointment:</h3>
    <form method="POST" class="vertForm">
        <input type="text" name="apptContent" placeholder='Describe Appointment'>
        <input type="text" name="date" placeholder='Eg. May 2, 2023'>
        <input type="text" name="inputMinutes" placeholder='Meeting Duration (Minutes)'>
        <input type="text" name="apptType" placeholder='Type of Appointment (eg. Meeting)'>
        <br>
        <button type="submit" name="addItemBtn">Submit</button>
    </form>
</div>