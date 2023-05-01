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

        <!-- area to add users to that board
        <div id="boardUsers">
            <h2>Add User to Board</h2>
            <form method="post">
                <label for="usr_id">User ID:</label>
                <input type="text" id="usr_id" name="usr_id">
                <input type="submit" value="Add User">
            </form>
            <?php
            if (isset($_POST["usr_id"])) {
                $usr_id = $_POST["usr_id"];
                $sql = "INSERT INTO board_assignments (usr_id, board_id) VALUES ($usr_id, $cur_board_id)";
                if ($conn->query($sql) === TRUE) {
                    echo "User added successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>

            <h3>Users on Board</h3>
            <ul style="list-style-position: inside; margin-left: 0; padding-left: 0; position: relative; top: -20px;">
                <?php
                $sql = "SELECT users.usr_id, users.usr_name FROM users INNER JOIN board_assignments ON users.usr_id = board_assignments.usr_id WHERE board_assignments.board_id = $cur_board_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<li>" . $row['usr_name'] . " (" . $row["usr_id"] . ")</li>";
                    }
                } else {
                    echo "No users currently assigned to this board.";
                }
                ?>
            </ul>
        </div> -->

        <div id="boardUsers">
            <h2>Add User to Board</h2>
            <form method="post">
                <label for="usr_id">User ID:</label>
                <input type="text" id="usr_id" name="usr_id">
                <input type="submit" value="Add User">
            </form>
            <?php
            if (isset($_POST["usr_id"])) {
                $usr_id = $_POST["usr_id"];
                $sql = "INSERT INTO board_assignments (usr_id, board_id) VALUES ($usr_id, $cur_board_id)";
                if ($conn->query($sql) === TRUE) {
                    echo "User added successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>
            <h2>Remove User from Board</h2>
            <form method="post">
                <label for="remove_usr_id">User ID:</label>
                <input type="text" id="remove_usr_id" name="remove_usr_id">
                <input type="submit" value="Remove User">
            </form>
            <?php
            if (isset($_POST["remove_usr_id"])) {
                $remove_usr_id = $_POST["remove_usr_id"];
                $sql = "DELETE FROM board_assignments WHERE board_id=$cur_board_id AND usr_id=$remove_usr_id";
                if ($conn->query($sql) === TRUE) {
                    echo "User removed successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>

            <h2>Current Board Users</h2>
            <ul>
                <?php
                $sql = "SELECT DISTINCT usr_id FROM board_assignments WHERE board_id = $cur_board_id";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $usr_id = $row["usr_id"];
                    $sql2 = "SELECT usr_name FROM users WHERE usr_id = $usr_id";
                    $result2 = $conn->query($sql2);
                    $row2 = $result2->fetch_assoc();
                    $usr_name = $row2["usr_name"];
                    echo "<li>$usr_id: $usr_name</li>";
                }
                ?>
            </ul>
        </div>

        
        
    </div>

</body>


</html>