<!-- This is a component that will be rendered in the Dashboard to display board appointments with editing capability -->
<!-- THIS FILE IS BY SLOAN DAVIS -->
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
if (isset($_POST['addItemBtn']) && isset($_POST['apptContent']) && isset($_POST['date']) && isset($_POST['inputMinutes']) && isset($_POST['apptType'])) {
    $content = $_POST['apptContent'];
    $type = $_POST['apptType'];
    $input_minutes = $_POST['inputMinutes'];
    $input_datetime = $_POST['date'];

    //set duration
    $hours = floor($input_minutes / 60);
    $minutes = $input_minutes % 60;
    
    // Format the time as HH:MM:SS
    $duration = sprintf('%02d:%02d:00', $hours, $minutes);

    //set meeting date and time
    $dt = new DateTime($input_datetime);
    $dt = $dt->format('Y-m-d H:i:s');
    //insert into appointments table
    $sql = "INSERT INTO appointment (appt_time, appt_duration, appt_type, board_id, appt_name) VALUES ('$dt', '$duration', '$type', $board_id, '$content')";
    $result = $conn->query($sql);
    $insert_id = mysqli_insert_id($conn);

    //insert into appointment_assignments table
    $sql = "INSERT INTO appointment_assignments (usr_id, appointment_id) VALUES (" . $_SESSION['usr_id'] . ", $insert_id)";
    $conn->query($sql);
}

//handle queries for update and delete
$appt_id = "";
if (isset($_POST['apptID'])) {
    $appt_id = $_POST['apptID'];
}
//delete appt
if (isset($_POST['deleteAppt'])) {
    //delete from appt
    $sql = "DELETE FROM appointment_assignments WHERE appointment_id = $appt_id";
    $conn->query($sql);
    //delete actual appointment
    $sql = "DELETE FROM appointment WHERE appt_id = $appt_id AND board_id = $board_id";
    $conn->query($sql);
}

//update appt
if (isset($_POST['updateAppt']) && isset($_POST['newUsr'])) {
    //check if user is in board
    //USES VIEW
    $sql = "SELECT usr_id FROM board_assign_usr WHERE usr_id = " . $_POST['newUsr'] . " AND board_id = $board_id";
    $result = $conn->query($sql);
    if ($result->num_rows != 0) {
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
        echo "<h5>appointment type:<b>" . $row['appt_type'] . "</b></h5>";
        echo "<h5>name:<b>" . $row['appt_name'] . "</b></h5>";
        echo "<h5>date & time:<b>" . $row['appt_time'] . "</b></h5>";
        echo "<h5>Length:<b>" . $row['appt_duration'] . "</b></h5>";
        echo "<input type='hidden' name='apptID' value='" . $row["appt_id"] . "'>";
        echo "<input type='text' name='newUsr' placeholder='user id'>";
        echo "<button type='submit' name='updateAppt'>Add Attendee</button>";
        echo "<button type='submit' name='deleteAppt'>Delete</button>";
        echo "</form>";
        echo "<hr>";
    }
    ?>
</div>
<div id="addAppointment">
    <h3>Add Appointment:</h3>
    <form method="POST" class="vertForm">
        <input type="text" name="apptContent" placeholder='Name Appointment'>
        <input type="text" name="date" placeholder='Date: May 2, 2023 4:00pm'>
        <input type="text" name="inputMinutes" placeholder='Duration (Minutes)'>
        <input type="text" name="apptType" placeholder='Type (eg. Meeting)'>
        <br>
        <button type="submit" name="addItemBtn">Submit</button>
    </form>
</div>