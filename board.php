<!-- This file displays the current status of the board, including meetings, comments, items, and current users. Also includes functionality around each. -->
<!-- This file was created by Sloan Davis & Logan Talton -->

<?php
session_start();
include("templates/db_login.php");
?>
<html>

<head>
    <title>My Board</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    include('templates/header.php');

    //make sure we have a board id
    $cur_board_id = "";
    if (!isset($_GET["boardID"])) {
        echo "no board found...";
        exit;
    }
    $cur_board_id = $_GET["boardID"];
    $_SESSION['curBoardID'] = $cur_board_id;

    //make sure user has authorization to view this board 
    $sql = "SELECT * FROM board_assignments WHERE usr_id = " . $_SESSION['usr_id'] . " AND board_id = " . $cur_board_id;
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "Incorrect Board Access";
        exit;
    }
    $row = $result->fetch_assoc();
    $access_level = $row['access_level'];
    $_SESSION["access_level"] = $access_level;

    $conn->close();
    ?>
    <div id="boardContainer">
        <div id="boardItems">
            <h2>Items</h2>
            <?php
            if ($access_level < 2) {
                include("./boardTemplates/itemsEditor.php");
            } else {
                include("./boardTemplates/itemsViewer.php");
            }
            ?>
        </div>
        <div id="boardAppointments">
            <h2>Appointments</h2>
            <?php
            if($access_level < 2){
                include("./boardTemplates/appointmentsEditor.php");
            }
            else{
                include("./boardTemplates/appointmentsViewer.php");
            }
            ?>
        </div>
        <div id="boardComments">
            <h2>Comments</h2>
            <?php 
            include("./boardTemplates/comments.php");
            ?>
        </div>
    </div>
    <hr>
    <?php
    if ($access_level == 0) {
        include("add_board_users.php");
    }
    ?>
</body>


</html>