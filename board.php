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
    //send user to correct board page based on access level
    // if ($access_level == 0) {
    //     header("Location: adminBoard.php");
    // } else if ($access_level == 1) {
    //     header("Location: editorBoard.php");
    // } else if ($access_level == 2) {
    //     header("Location viewerBoard.php");
    // } else {
    //     echo "no valid access level";
    //     exit;
    // }

    // adding a user to the board handling
    if (isset($_POST['addUser'])) {
        $newUser = $_POST['newUser'];
        // Check if user ID exists
        $sql = "SELECT * FROM users WHERE usr_id = " . $newUser;
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            echo "User ID not found.";
        } else {
            // Check if user is already assigned to board
            $sql = "SELECT * FROM board_assignments WHERE board_id = $cur_board_id AND usr_id = $newUser";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "User is already assigned to this board.";
            } else {
                // Add new row to board_assignments table
                $sql = "INSERT INTO board_assignments (board_id, usr_id, access_level) VALUES ($cur_board_id, $newUser, 2)";
                if ($conn->query($sql) === TRUE) {
                    echo "User added to board.";
                    // Reload current page
                    header("Refresh:0");
                } else {
                    echo "Error adding user: " . $conn->error;
                }
            }
        }
    }

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
            <h2>Board Appointments</h2>
        </div>
        <div id="boardComments">
            <h2>Board Comments</h2>
        </div>
    </div>
    <hr>
    <?php 
    if($access_level == 0){
        include("add_board_users.php");
    }
    ?>
</body>


</html>