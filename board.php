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


    $conn->close();
    ?>
    <div id="boardContainer">
        <div id="boardItems"></div>
        <div id="boardAppointments"></div>
        <div id="boardComments"></div>
    </div>



</body>


</html>