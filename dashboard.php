<!-- This file displays the dashboard for a user. It lists each board a user is apart of aand any boards they own. It also allows the user to create a board-->
<!-- This file was created by Justin Heger -->
<!-- This file was edited by Logan Talton and Sloan Davis -->

<?php session_start(); ?>
<html>

<?php include('templates/head.php'); ?>

<body>
    <?php include('templates/header.php'); ?>
    <?php include('templates/db_login.php'); ?>

    <?php
    //Store username from login
    //if usr_name not set, return to index
    if (!isset($_SESSION['usr_name'])) {
        header('Location: index.php');
        exit;
    }

    // // Retrieve user id associated with username
    $sql = "SELECT usr_id FROM users WHERE usr_name = '" . $_SESSION['usr_name'] . "'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $usr_id = $row['usr_id'];
    $_SESSION['usr_id'] = $usr_id;

    //update username handler
    if (isset($_POST['updateUsername']) && isset($_POST['newUsername'])) {
        $sql = "UPDATE users SET usr_name = '" . $_POST['newUsername'] . "' WHERE usr_id = $usr_id";
        $conn->query($sql);
        $_SESSION['usr_name'] = $_POST['newUsername'];
    }
    ?>

    <!-- Display welcome messsage for usr_name -->
    <p style="padding-left: 10px">Welcome <?php echo $_SESSION['usr_name']; ?>!</p>
    <p style="padding-left: 10px"> Your user id is <?php echo $usr_id; ?> </p>
    <hr>

    <!-- Create board -->
    <p style="padding-left: 10px">Create a board</p>
    <form action="create_board.php" method="post" style="padding-left: 10px">
        <input type="text" name="board_name" placeholder="Board name">
        <input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>">
        <input type="submit" value="Create board">
    </form>

    <!-- Delete a board user is admin of -->
    <p style="padding-left: 10px">Delete a board</p>
    <form action="delete_board.php" method="post" style="padding-left: 10px">
        <input type="text" name="board_id" placeholder="Board ID">
        <input type="hidden" name="usr_id" value="<?php echo $usr_id; ?>">
        <input type="submit" value="Delete board">
    </form>
    <hr>

    <!-- Display boards that user is in-->
    <p style="padding-left: 10px"><b>Boards that you are in:</b></p>
    <?php
    // $sql = "SELECT * FROM board_assignments WHERE usr_id = '" . $usr_id . "'";
    // $result = $conn->query($sql);
    // while ($row = $result->fetch_assoc()) {
    //     echo "<form method='post' style='padding-left: 10px' action='board.php?boardID=" . $row["board_id"] . "'>";
    //     echo $row["board_id"] . ": " . "<input type='submit' name='loadBoardButton' value='Go To Board' >";
    //     echo "</form>";
    //     //allows board.php to know if user has access to the board
    //     $_SESSION["b_id_". $row["board_id"]] = true;
    // }
    $sql = "SELECT b.board_id, b.board_name
    FROM board_assignments ba
    JOIN board b ON ba.board_id = b.board_id
    WHERE ba.usr_id = '" . $usr_id . "'"; //. "' OR b.board_admin_id = '" . $usr_id . "'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo "<form method='post' style='padding-left: 10px' action='board.php?boardID=" . $row["board_id"] . "'>";
        echo $row["board_name"] . ": " . "<input type='submit' name='loadBoardButton' value='Go To Board' >";
        echo "</form>";
        //allows board.php to know if user has access to the board
        $_SESSION["b_id_" . $row["board_id"]] = true;
    }
    ?>
    <hr>

    <!-- Display boards that user is admin of -->
    <p style="padding-left: 10px"><b>Boards you are admin of:</b></p>
    <?php
    $sql = "SELECT * FROM board WHERE board_admin_id = $usr_id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        #print each row (board_id board_name board_admin_id)
        echo "<p style='padding-left: 10px'>Board name: " . $row["board_name"] . "<br> Board id: " . $row["board_id"] .  "<br> Board admin id: " . $row["board_admin_id"] . " <br>" . "</p>";
    }
    $conn->close();
    ?>
    <hr>

    <p style="padding-left: 10px"><b>Account Actions</b></p>
    <form method="POST">
        <input type="text" name="newUsername" placeholder="new username">
        <button type="submit" name="updateUsername">Update Username</button>
    </form>
    <form method="post" action="delete_account.php">
        <button id="deleteAccountBtn" type="submit" name="deleteAccount">Delete Account</button>
    </form>

</body>

</html>